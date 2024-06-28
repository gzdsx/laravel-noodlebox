<?php

namespace App\Traits\RestApis;

use App\Events\OrderChanged;
use App\Events\OrderCreated;
use App\Models\Cart;
use App\Models\Deliveryer;
use App\Models\Order;
use App\Models\OrderNote;
use App\Models\ShippingZone;
use App\Models\UserPhone;
use App\Models\UserPointTransaction;
use App\Support\TradeUtil;
use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait OrderApis
{
    /**
     * @return \App\Models\Order|Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function repository()
    {
        return Auth::user()->boughts()->withGlobalScope('avalaible', function (Builder $builder) {
            return $builder->where('buyer_deleted', 0);
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->filter($request->all());
        $total = $query->count();
        $items = $query->offset($request->input('offset', 0))
            ->limit($request->input('limit', 10))
            ->orderByDesc('created_at')->get();

        return json_success([
            'total' => $total,
            'items' => $items
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
     * @return mixed
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'payment_method' => 'required',
            'shipping_line' => 'required',
            'shipping' => 'required',
            'items' => 'required',
        ]);

        return DB::transaction(function () use ($request) {
            $order = $this->repository()->make();
            $order->order_no = TradeUtil::createOrderNo();
            $order->out_trade_no = TradeUtil::createOutTradeNo();
            $order->payment_method = $request->input('payment_method');
            $order->payment_method_title = $request->input('payment_method_title');
            $order->shipping_line = $request->input('shipping_line', []);
            $order->buyer_note = $request->input('buyer_note');
            $order->shipping = $request->input('shipping', []);
            $order->billing = $request->input('billing', []);
            $order->created_via = $request->input('created_via', 'checkout');

            $buyer = Auth::user();
            $order->buyer_id = $buyer->id;
            $order->buyer_name = $buyer->nickname;

            $phone_number = $order->shipping['phone']['phone_number'] ?? '';
            $national_number = $order->shipping['phone']['national_number'] ?? '';
            if (!UserPhone::checkPhoneNumber($buyer->id, $phone_number, $national_number)) {
                abort(422, 'Phone number not verified');
            }

            $total = 0;
            $fee_lines = $request->input('fee_lines', []);
            foreach ($fee_lines as $fee_line) {
                $total += $fee_line['total'] ?? 0;
            }
            $order->fee_lines = $fee_lines;

            if ($order->shipping_line['method_id'] == 'flat_rate') {
                $order->shipping_total = $order->shipping_line['total'] ?? 0;
                $total += $order->shipping_total;
            }

            $discount_total = 0;
            $discount_lines = $request->input('discount_lines', []);
            foreach ($discount_lines as $discount_line) {
                $total -= $discount_line['total'] ?? 0;
                $discount_total += $discount_line['total'] ?? 0;
            }

            $order->discount_lines = $discount_lines;
            $order->discount_total = $discount_total;
            $order->save();

            $meta_data = $request->input('meta_data', []);
            foreach ($meta_data as $key => $value) {
                $order->updateMeta($key, $value);
            }

            $items = $request->input('items', []);
            foreach ($items as $item) {
                $order->items()->create($item);
            }

            $earn_points_total = 0;
            $consume_points_total = 0;
            foreach ($order->items()->with(['product'])->get() as $item) {
                $total += $this->calculateItemTotal($item);
                $earn_points_total += $this->calculateItemEarnPoints($item);
                $consume_points_total = $this->calculateItemComsumePoints($item);
            }

            $order->total = $total;
            if ($order->shipping_line['method_id'] == 'flat_rate') {
                $order->status = Order::ORDER_STATUS_PROCESSIING;
                if ($order->payment_method == 'online') {
                    $order->payment_status = 1;
                    $order->payment_at = now();
                }
            } else {
                $order->status = Order::ORDER_STATUS_COMPLETED;
                $order->payment_status = 1;
                $order->payment_at = now();
            }

            $order->save();

            //积分抵扣现金
            $use_points_value = $request->input('use_points_value', 0);
            if ($use_points_value > 0) {
                $buyer->points -= $use_points_value;
                $buyer->save();

                $transaction = new UserPointTransaction();
                $transaction->user_id = $buyer->id;
                $transaction->points = $use_points_value;
                $transaction->type = 2;
                $transaction->detail = 'Deduction of points for cash';
                $transaction->save();
            }

            //消费积分
            if ($consume_points_total > 0) {
                $buyer->points -= $consume_points_total;
                $buyer->save();

                $transaction = new UserPointTransaction();
                $transaction->user_id = $buyer->id;
                $transaction->points = $consume_points_total;
                $transaction->type = 2;
                $transaction->detail = 'purchase via points';
                $transaction->save();
            }

            //赚取积分
            if ($earn_points_total > 0) {
                $buyer->points += $earn_points_total;
                $buyer->save();

                $transaction = new UserPointTransaction();
                $transaction->user_id = $buyer->id;
                $transaction->points = $earn_points_total;
                $transaction->type = 1;
                $transaction->detail = 'purchase earn points';
                $transaction->save();
            }

            event(new OrderCreated($order));

            //更新地址
            Auth::user()->updateMeta('billing_address', $order->billing);
            Auth::user()->updateMeta('shipping_address', $order->shipping);

            $model = $this->repository()->find($order->id);
            $self_link = url('orders/' . $order->id);
            $approval_link = url('orders/' . $order->id);

            Cart::whereUserId($buyer->id)->delete();
            return json_success([
                'order' => $model,
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => $self_link,
                        'method' => 'GET',
                    ],
                    [
                        'rel' => 'approval',
                        'href' => $approval_link,
                        'method' => 'GET',
                    ],
                ],
            ]);
        });
    }

    public function update($id, Request $request)
    {
        $order = $this->repository()->findOrFail($id);

        if ($request->has('metas')) {
            $metas = $request->input('metas', []);
            foreach ($metas as $meta) {
                $order->updateMeta($meta['meta_key'], $meta['meta_value']);
            }
        }

        if ($request->has('items')) {
            $items = $request->input('items', []);
            $ids = array_column($items, 'id');
            if (count($ids) > 0) {
                $order->items()->whereNotIn('id', $ids)->delete();
            }

            foreach ($items as $item) {
                $order->items()->updateOrCreate(['id' => $item['id']], $item);
            }
        }

        $order_notes = [];
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status !== $order->status) {
                $order_notes[] = 'Order status changed from ' . $order->status . ' to ' . $status . '.';
                $order->status = $status;
            }
        }

        $is_modified = $order->is_modified;
        if ($request->has('shipping_line')) {
            $shipping_line = $request->input('shipping_line');
            if ($shipping_line['zone_id'] != $order->shipping_line['zone_id']) {
                $order_notes[] = 'Order shipping method changed from ' . $order->shipping_line['method_title'] . ' to ' . $shipping_line['method_title'] . '.';
                $order->shipping_line = $shipping_line;
                $order->shipping_total = $shipping_line['total'] ?? 0;
                $is_modified = true;
            }
        }

        if ($request->has('deliveryer_id')) {
            if ($order->shipping_line['method_id'] == 'flat_rate') {
                $deliveryer_id = $request->input('deliveryer_id');
                if ($deliveryer_id != $order->deliveryer_id) {
                    $deliveryer = Deliveryer::find($deliveryer_id);
                    if ($deliveryer) {
                        $order_notes[] = 'Order assigned deliveryer:' . $deliveryer->name;
                        $order->deliveryer_id = $deliveryer_id;
                    }
                }
            } else {
                $order->deliveryer_id = 0;
            }
        }

        if ($order->deliveryer_id) {
            $order->status = Order::ORDER_STATUS_COMPLETED;
        }

        if ($request->has('payment_method')) {
            $payment_method = $request->input('payment_method');
            if ($payment_method != $order->payment_method) {
                $content = 'Order payment method changed from ' . __('payment.methods.' . $order->payment_method) . ' to ' . __('payment.methods.' . $payment_method) . '.';
                $order_notes[] = $content;
                $order->payment_method = $payment_method;
                $order->payment_method_title = $request->input('payment_method_title');
                $is_modified = true;
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

        $order->is_modified = $is_modified;
        $order->save();

        foreach ($order_notes as $content) {
            $note = new OrderNote();
            $note->order_id = $order->id;
            $note->user_id = Auth::id();
            $note->content = $content;
            $note->save();
        }

        return json_success($order);
    }

    protected function calculateItemTotal($item)
    {
        return $item->price * $item->quantity;
    }

    protected function calculateItemEarnPoints($item)
    {
        $points = 0;
        if ($item->product) {
            $points = $item->product->points * $item->quantity;
        }

        return $points;
    }

    protected function calculateItemComsumePoints($item)
    {
        $points = 0;
        if ($item->product && is_array($item['meta_data'])) {
            if (isset($item['meta_data']['purchase_via']) && $item['meta_data']['purchase_via'] == 'point') {
                $points = $item->product->point_price * $item->quantity;
            }
        }

        return $points;
    }
}