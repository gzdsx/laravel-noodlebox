<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Models\Deliveryer;
use App\Models\DeliveryerTransaction;
use App\Models\PosMachine;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DeliveryerController extends BaseController
{
    protected function repository()
    {
        return \App\Models\Deliveryer::query();
    }

    public function index(Request $request)
    {
        $query = $this->repository();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return json_success([
            'total' => $query->count(),
            'items' => $query->with(['posMachines'])->get()
        ]);
    }

    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        $model->load(['posMachines']);
        return json_success($model);
    }

    public function store(Request $request, $id = null)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->only($model->getFillable()));
        $model->save();

        if ($model->status === Deliveryer::STATUS_ONLINE) {
            if ($request->has('pos_machines')) {
                $ids = collect($request->input('pos_machines', []))->pluck('id');
                PosMachine::whereKey($ids)->update([
                    'deliveryer_id' => $model->id,
                    'status' => PosMachine::STATUS_INUSE
                ]);
            }
        } elseif ($model->status === Deliveryer::STATUS_OFFLINE) {
            $model->posMachines()->update([
                'deliveryer_id' => 0,
                'status' => PosMachine::STATUS_IDLE
            ]);
        }

        return json_success($model);
    }

    public function update($id, Request $request)
    {
        $model = $this->repository()->findOrNew($id);
        $model->fill($request->only($model->getFillable()));
        $model->save();

        if ($model->status === Deliveryer::STATUS_ONLINE) {
            if ($request->has('pos_machines')) {
                PosMachine::where('deliveryer_id', $model->id)->update([
                    'deliveryer_id' => 0,
                    'status' => PosMachine::STATUS_IDLE
                ]);
                $ids = collect($request->input('pos_machines', []))->pluck('id');
                PosMachine::whereKey($ids)->update([
                    'deliveryer_id' => $model->id,
                    'status' => PosMachine::STATUS_INUSE
                ]);
            }
        } elseif ($model->status === Deliveryer::STATUS_OFFLINE) {
            $model->posMachines()->update([
                'deliveryer_id' => 0,
                'status' => PosMachine::STATUS_IDLE
            ]);
        }

        return json_success($model);
    }

    public function destroy($id, Request $request)
    {
        if ($id === 'batch') {
            $this->repository()->whereKey($request->input('ids', []))->get()->each->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return json_success();
    }

    public function settlement(Request $request, $id)
    {
        $amount = $request->input('amount');
        $model = $this->repository()->findOrFail($id);

        $transaction = new DeliveryerTransaction();
        $transaction->amount = $amount;
        $transaction->deliveryer_id = $model->id;
        $transaction->note = $request->input('note');
        $transaction->type = 'income';
        $transaction->save();
        return json_success();
    }

    public function orders($id, Request $request)
    {
        $deliveryer = $this->repository()->findOrFail($id);
        $orders = $deliveryer->orders()->get();
        return json_success([
            'total' => $orders->count(),
            'items' => $orders
        ]);
    }

    public function calculateFee($id, Request $request)
    {
        $deliveryer = $this->repository()->findOrFail($id);

        $base_total = $deliveryer->base_amount;
        $shipping_total = 0;
        $cash_total = 0;
        $cost_total = 0;
        $card_total = 0;
        $online_total = 0;

        $orders = $deliveryer->orders()->get();
        foreach ($orders as $order) {
            $shipping_total += $order->shipping_total;
            $cash_total = $order->meta_data['payment_with_cash_value'] ?? 0;
            $cost_total = $order->meta_data['cost_total'] ?? 0;
            if ($order->payment_method === 'card') {
                $card_total += $order->total;
            }

            if ($order->payment_method === 'online') {
                $online_total += $order->total;
            }
        }

        $total = $card_total + $cash_total + $cost_total - $shipping_total;
        return json_success([
            'base_total' => format_amount($base_total),
            'shipping_total' => format_amount($shipping_total),
            'cash_total' => format_amount($cash_total),
            'cost_total' => format_amount($cost_total),
            'card_total' => format_amount($card_total),
            'online_total' => format_amount($online_total),
            'total' => format_amount($total)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function billing($id)
    {
        $time = Carbon::createFromTimeString(settings('opening_hours_end'));
        if ($time->isAfter(now())) {
            $time = $time->subDay();
        }
        $deliveryer = Deliveryer::with(['orders' => function ($query) use ($time) {
            return $query->where('created_at', '>', $time);
        }])->find($id);
        $deliveryer->bill = $deliveryer->generateBill();
        return json_success($deliveryer);
    }
}
