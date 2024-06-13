<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2020 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: https://www.gzdsx.cn
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2020/4/21
 * Time: 9:11 下午
 */

namespace App\Traits\RestApis;


use App\Models\Deliveryer;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\ShippingZone;
use App\Support\TradeUtil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait SoldApis
{
    /**
     * @return Order|Builder
     */
    protected function repository()
    {
        return Order::query();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->filter($request->all());
        return json_success([
            'total' => $query->count(),
            'items' => $query->offset($request->input('offset', 0))
                ->limit($request->input('limit', 10))
                ->orderByDesc('created_at')->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $order = $this->repository()->findOrFail($id);

        $order_notes = [];
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status !== $order->status) {
                $order_notes[] = 'Order status changed from ' . $order->status . ' to ' . $status . '.';
                $order->status = $status;
            }
        }

        $is_modified = $order->is_modified;
        if ($request->has('shipping_method')) {
            $shipping_method = $request->input('shipping_method');
            if ($shipping_method != $order->shipping_method) {
                $order_notes[] = 'Order shipping method changed from ' . $order->shipping_method . ' to ' . $shipping_method . '.';
                $order->shipping_method = $shipping_method;
                $is_modified = true;
            }
        }

        if ($request->has('shipping_zone_id')) {
            $shipping_zone_id = $request->input('shipping_zone_id');
            $shipping_zone = ShippingZone::find($shipping_zone_id);
            if ($shipping_zone) {
                $order->total = $order->total - $order->shipping_total + $shipping_zone->fee;
                $order->shipping_total = $shipping_zone->fee;
                $order->shipping_zone_id = $shipping_zone_id;
            }
        }

        if ($request->has('payment_method')) {
            $payment_method = $request->input('payment_method');
            if ($payment_method != $order->payment_method) {

                $content = 'Order payment method changed from ' . __('payment.methods.' . $order->payment_method) . ' to ' . __('payment.methods.' . $payment_method) . '.';
                if ($payment_method == 'customize') {
                    $payment_cash_amount = $request->input('payment_cash_amount');
                    $content .= '<br />By Card:' . ($order->total - $payment_cash_amount);
                    $content .= '<br />By Cash:' . $payment_cash_amount;
                }

                $order_notes[] = $content;
                $order->payment_method = $payment_method;
                $is_modified = true;
            }
        }

        if ($shipping_method == 'collection') {
            $order->deliveryer_id = 0;
        } else {
            if ($request->has('deliveryer_id')) {
                $deliveryer_id = $request->input('deliveryer_id');
                if ($deliveryer_id != $order->deliveryer_id) {
                    //$is_modify = true;
                    $deliveryer = Deliveryer::find($deliveryer_id);
                    if ($deliveryer) {
                        $order_notes[] = 'Order assigned deliveryer:' . $deliveryer->name;
                        $order->deliveryer_id = $deliveryer_id;
                    }
                }
            }
        }

        if ($request->has('total')) {
            $total = $request->input('total');
            if ($total != $order->total) {
                $order_notes[] = 'Order total changed from ' . $order->total . ' to ' . $total . '.';
                $order->total = $total;
                $is_modified = true;
            }
        }

        if ($request->has('buyer_note')) {
            $buyer_note = $request->input('buyer_note');
            if ($buyer_note != $order->buyer_note) {
                $order->buyer_note = $request->input('buyer_note');
                $order_notes[] = 'Buyer note changed to ' . $request->input('buyer_note') . '.';
                $is_modified = true;
            }
        }

        if ($request->has('fee_lines')) {
            $order->fee_lines = $request->input('fee_lines', []);
        }

        if ($request->has('discount_lines')) {
            $order->discount_lines = $request->input('discount_lines', []);
        }

        $order->short_code = $request->input('short_code', '');
        $order->is_modified = $is_modified;
        $order->save();

        if ($request->has('items')) {
            $order_items = $request->input('items', []);
            $ids = array_column($order_items, 'id');
            if (count($ids) > 0) {
                $order->items()->whereNotIn('id', $ids)->delete();
            }

            foreach ($order_items as $item) {
                $order->items()->updateOrCreate(['id' => $item['id']], $item);
            }
        }

        foreach ($order_notes as $content) {
            $note = new OrderNote();
            $note->order_id = $order->id;
            $note->user_id = Auth::id();
            $note->content = $content;
            $note->save();
        }

        return json_success($order);
    }

    /**
     * 调整价格
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adjustPrice(Request $request)
    {
        $order_fee = floatval($request->input('order_fee'));
        $order = $this->repository()->findOrFail($request->input('order_id'));
        if ($order->order_state == 1) {
            $discount_fee = bcsub($order->total_fee, $order_fee);
            $order->order_fee = $order_fee;
            $order->discount_fee = $discount_fee;
            $order->save();
            if ($order->transaction) {
                $order->transaction->amount = $order_fee;
                $order->transaction->out_trade_no = TradeUtil::createOrderNo();
                $order->transaction->save();
            }
        }

        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $order = $this->repository()->findOrFail($request->input('order_id'));
        if ($order->order_state == 2) {
            $shipping = $order->shipping()->firstOrNew();
            $shipping->express_code = $request->input('express_code');
            $shipping->express_name = $request->input('express_name');
            $shipping->express_no = $request->input('express_no');
            $shipping->save();

            $order->markAsShipped();
        }

        return json_success($order);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function forceDelete(Request $request)
    {
        $order = $this->repository()->findOrFail($request->input('order_id'));
        $order->forceDelete();
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $order = $this->repository()->findOrFail($request->input('order_id'));
        $order->seller_deleted = 1;
        $order->save();
        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(Request $request)
    {
        $order = $this->repository()->findOrFail($request->input('order_id'));
        if ($order->isPaid()) {
            $order->markAsAccepted();
        }

        return json_success();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request)
    {
        $order = $this->repository()->findOrFail($request->input('order_id'));
        $order->markAsCancelled();

        return json_success();
    }
}
