<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Admin\BaseController;
use App\Models\CashierTransaction;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\PosMachine;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CashierTransactionController extends BaseController
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
        $transaction = $this->generateBilling();
        $transaction->user()->associate($request->user());
        if ($request->filled('pos_balance')) {
            $transaction->pos_balance = $request->input('pos_balance');
        }

        if ($request->filled('status')) {
            $transaction->status = $request->input('status');
        }

        $transaction->save();

        return json_success($transaction);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $transaction = $this->repository()->findOrFail($id);
        $transaction->status = $request->input('status');
        $transaction->notes = $request->input('notes');
        $transaction->save();

        return json_success($transaction);
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

    public function billing()
    {
        $transaction = $this->generateBilling();
        return json_success($transaction);
    }

    protected function generateBilling()
    {
        $transaction = new CashierTransaction([
            'base_amount' => 0,
            'cost_total' => 0,
            'shipping_total' => 0,
            'cash_total' => 0,
            'online_total' => 0,
            'card_total' => 0,
            'refund_total' => 0,
            'actual_total' => 0,
            'pos_balance' => 0,
            'total' => 0,
            'notes' => '',
            'status' => 'pending'
        ]);

        $last = CashierTransaction::orderByDesc('created_at')->first();
        if ($last) {
            $orders = Order::completed()->where('completed_at', '>', $last->created_at)->get();
            $transaction->base_amount = $last->pos_balance;
            $transaction->pos_balance = $last->pos_balance;
        } else {
            $orders = Order::completed()->get();
        }

        if ($orders->count()) {
            foreach ($orders as $order) {
                $transaction->total = bcadd($transaction->total, $order->total, 2);
                $transaction->cost_total = bcadd($transaction->cost_total, $order->cost_total, 2);
                $transaction->shipping_total = bcadd($transaction->shipping_total, $order->shipping_total, 2);

                if ($order->payment_method === 'cash' || $order->payment_method === 'card') {
                    $transaction->cash_total = bcadd($transaction->cash_total, $order->total, 2);
                } elseif ($order->payment_method === 'online') {
                    $transaction->online_total = bcadd($transaction->online_total, $order->total, 2);
                } elseif ($order->payment_method === 'card_reader') {
                    $transaction->card_total = bcadd($transaction->card_total, $order->total, 2);
                } elseif ($order->payment_method === 'customize') {
                    $transaction->cash_total = bcadd($transaction->cash_total, floatval($order->getMeta('payment_with_cash_value', 0)), 2);
                    $transaction->card_total = bcadd($transaction->card_total, floatval($order->getMeta('payment_with_card_value', 0)), 2);
                }

                if ($order->refund_at) {
                    $transaction->refund_total = bcadd($transaction->refund_total, $order->total, 2);
                }
            }
            $transaction->base_amount = format_amount(0);
            $transaction->refund_total = format_amount($transaction->refund_total);
            $transaction->actual_total = bcadd($transaction->cash_total, $transaction->cost_total, 2);
            $transaction->actual_total = bcsub($transaction->actual_total, $transaction->shipping_total, 2);
        }

        return $transaction;
    }
}
