<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierTransactionController extends Controller
{
    /**
     * @return \App\Models\CashierTransaction|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return \App\Models\CashierTransaction::query();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository();
        $request->whenHas('date', function ($input) use ($query) {
            $query->whereDate('created_at', $input);
        });

        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 15))
                ->orderByDesc('id')
                ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $total = 0;
        $cash_total = 0;
        $online_total = 0;
        $card_total = 0;
        $refund_total = 0;
        $shipping_total = 0;
        $cash_profit_total = 0;

        $orders = Order::where([])->get();
        foreach ($orders as $order) {
            $total += $order->total;
            $shipping_total += $order->shipping_total;

            if ($order->payment_method === 'cash') {
                $cash_total += $order->total;
            } elseif ($order->payment_method === 'online') {
                $online_total += $order->total;
            } elseif ($order->payment_method === 'card') {
                $card_total += $order->total;
            } elseif ($order->payment_method === 'customize') {
                $cash_total += $order->meta_data['payment_with_cash_value'] ?? 0;
            }

            if ($order->refund_at) {
                $refund_total += $order->total;
            }
        }

        $model = $this->repository()->whereDate('created_at', now())->firstOrNew();
        $model->total = $total;
        $model->shipping_total = $shipping_total;
        $model->cash_total = $cash_total;
        $model->online_total = $online_total;
        $model->card_total = $card_total;
        $model->refund_total = $refund_total;
        $model->cash_profit_total = $cash_total - $refund_total;
        $model->notes = $request->input('notes');
        $model->save();

        return json_success($model);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, Request $request)
    {
        if ($id === 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return json_success();
    }
}
