<?php

namespace App\Traits\RestApis;

use App\Events\OrderChanged;
use App\Events\OrderCreated;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Cart;
use App\Models\Deliveryer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNote;
use App\Models\ShippingZone;
use App\Models\UserPhone;
use App\Models\UserPointTransaction;
use App\Support\Paypal;
use App\Support\TradeUtil;
use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait OrderApis
{
    protected function getPaymentMethods()
    {
        return [
            [
                'id' => 'online',
                'title' => 'Pay Online (PayPal & Credit Car)',
                'description' => 'Pay Online (PayPal & Credit Car)',
                'fee' => '0.50',
                'img' => asset('images/noodlebox/Full_Online.png')
            ],
            [
                'id' => 'card',
                'title' => 'Pay by Card Reader',
                'description' => 'Pay by Card Reader',
                'fee' => '0.50',
                'img' => asset('images/noodlebox/pay_by_card.png')
            ],
            [
                'id' => 'cash',
                'title' => 'Pay Cash',
                'description' => 'Pay Cash',
                'fee' => '0.00',
                'img' => asset('images/noodlebox/pay_cash.png')
            ]
        ];
    }

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
     * @param OrderCreateRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function store(OrderCreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $order = $this->repository()->make();
            $order->order_no = TradeUtil::createOrderNo();
            $order->out_trade_no = $request->input('out_trade_no');
            $order->payment_method = $request->input('payment_method');
            $order->shipping_method = $request->input('shipping_method', Order::SHIPPING_METHOD_LOCALPICKUP);
            $order->buyer_note = $request->input('buyer_note');
            $order->shipping = $request->input('shipping', []);
            $order->billing = $request->input('billing', []);
            $order->created_via = $request->input('created_via', 'web');
            $order->status = Order::STATUS_PROCESSIING;

            $buyer = Auth::user();
            $order->buyer_id = $buyer->id;
            $order->buyer_name = $buyer->nickname;

            $total = 0;
            $mata_data = [];
            $order->shipping_total = 0;
            $shipping_zone_id = $request->shipping_zone_id;
            if ($order->shipping_method == Order::SHIPPING_METHOD_FLATRATE) {
                $zone = ShippingZone::findOrNew($shipping_zone_id);
                $order->shipping_line = [
                    'method_id' => Order::SHIPPING_METHOD_FLATRATE,
                    'method_title' => 'Delivery',
                    'zone_id' => $zone->id,
                    'zone_title' => $zone->title,
                    'total' => $zone->fee
                ];
                $order->shipping_total = $zone->fee ?: 0;
                $total = bcadd($total, $order->shipping_total, 2);
            } else {
                $order->shipping_line = [];
            }

            $fee_lines = [];
            $payment_method = $request->input('payment_method') ?: 'onine';
            foreach ($this->getPaymentMethods() as $method) {
                if ($payment_method == $method['id']) {
                    if ($method['fee'] > 0) {
                        $fee_lines[] = [
                            'name' => 'ADM Fee',
                            'total' => format_amount($method['fee'])
                        ];
                        $total = bcadd($total, $method['fee'], 2);
                    }
                }
            }
            $order->fee_lines = $fee_lines;
            $order->payment_method = $payment_method;

            $discount_lines = [];
            $use_points_value = $request->input('use_points_value', 0);
            $meta_data['use_points_value'] = $use_points_value;

            if ($use_points_value > 0) {
                $exchange_rate = settings('points_exchange_rate', 1);
                $use_points_amount = bcmul($use_points_value, $exchange_rate, 2);
                $discount_lines[] = [
                    'name' => 'Points deduction',
                    'total' => $use_points_amount
                ];
                $total = bcsub($total, $use_points_amount, 2);
                $order->discount_total = bcadd($order->discount_total, $use_points_amount, 2);
            }
            $order->discount_lines = $discount_lines;

            //赢取积分总额
            $earn_points_total = 0;
            //消费积分总额
            $consume_points_total = 0;
            $order_items = [];
            $cart_items = $buyer->carts()->with(['product'])->get();
            foreach ($cart_items as $item) {
                $total = bcadd($total, $this->calculateItemTotal($item), 2);
                $earn_points_total += $this->calculateItemEarnPoints($item);
                $consume_points_total += $this->calculateItemComsumePoints($item);

                $order_items[] = new OrderItem($item->toArray());
            }

            if ($consume_points_total > $buyer->points) {
                abort(422, 'Insufficient points');
            }

            $order->total = $total;
            if ($order->payment_method == 'online') {
                //$order->payment_at = now();
                $order->status = Order::STATUS_PENDING;
            }
            $order->save();
            $order->items()->saveMany($order_items);

            foreach ($meta_data as $key => $value) {
                $order->updateMeta($key, $value);
            }

            //积分抵扣现金
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
                //$buyer->points -= $consume_points_total;
                //$buyer->save();

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
            Auth::user()->updateMeta('shipping_zone_id', $shipping_zone_id);

            Cart::whereUserId($buyer->id)->delete();
            return json_success([
                'orderID' => $order->id,
                'totalAmount' => $order->total,
                'links' => [
                    [
                        'href' => url('orders/' . $order->id),
                        'method' => 'GET',
                        'rel' => 'approval'
                    ]
                ],
            ]);
        });
    }

    public function update($id, Request $request)
    {
        $order = $this->repository()->findOrFail($id);

        if ($request->has('meta_data')) {
            $meta_data = $request->input('meta_data', []);
            foreach ($meta_data as $key => $value) {
                $order->updateMeta($key, $value);
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
        if ($request->filled('shipping_method')) {
            $shipping_method = $request->input('shipping_method');
            if ($shipping_method != $order->shipping_method) {
                $order_notes[] = 'Shipping method changed from ' . $order->shipping_method . ' to ' . $shipping_method . '.';
                $order->shipping_method = $shipping_method;
            }
        }

        if ($order->shipping_method == Order::SHIPPING_METHOD_LOCALPICKUP) {
            $order->shipping_line = array_merge($order->shipping_line, [
                'method_id' => Order::SHIPPING_METHOD_LOCALPICKUP,
                'method_title' => 'Collection',
            ]);
            $order->shipping_total = 0;
        } else {
            $shipping_line = $request->input('shipping_line');
            $zone = ShippingZone::findOrNew($shipping_line['zone_id']);
            if ($zone->id != $order->shipping_line['zone_id']) {
                $order_notes[] = 'Shipping zone changed from ' . $order->shipping_line['zone_title'] . ' to ' . $zone->title . '.';
                $is_modified = true;
            }
            $order->shipping_line = [
                'method_id' => Order::SHIPPING_METHOD_FLATRATE,
                'method_title' => 'Delivery',
                'zone_id' => $zone->id,
                'zone_title' => $zone->title,
                'total' => $zone->fee,
            ];
            $order->shipping_total = $zone->fee ?: 0;
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
            $order->status = Order::STATUS_COMPLETED;
        }

        if ($request->filled('payment_method')) {
            $payment_method = $request->input('payment_method');
            if ($payment_method != $order->payment_method) {
                $content = 'Order payment method changed from ' . __('payment.methods.' . $order->payment_method) . ' to ' . __('payment.methods.' . $payment_method) . '.';
                $order_notes[] = $content;
                $order->payment_method = $payment_method;
                $order->payment_method_title = $request->input('payment_method_title');
                $is_modified = true;
            }

            $order->payment_method_title = $request->input('payment_method_title');
        }

        if ($request->filled('total')) {
            $total = $request->input('total');
            if ($total != $order->total) {
                $order_notes[] = 'Order total changed from ' . $order->total . ' to ' . $total . '.';
                $order->total = $total;
                $is_modified = true;
            }
        }

        if ($request->filled('buyer_note')) {
            $buyer_note = $request->input('buyer_note');
            if ($buyer_note != $order->buyer_note) {
                $order->buyer_note = $request->input('buyer_note');
                $order_notes[] = 'Buyer note changed to ' . $request->input('buyer_note') . '.';
                $is_modified = true;
            }
        }

        if ($request->filled('fee_lines')) {
            $order->fee_lines = $request->input('fee_lines', []);
        }

        if ($request->filled('discount_lines')) {
            $order->discount_lines = $request->input('discount_lines', []);
        }

        if ($request->filled('cost_total')) {
            $cost_total = $request->input('cost_total');
            if ($cost_total != $order->cost_total) {
                $order_notes[] = 'Cost total changed from ' . $order->cost_total . ' to ' . $cost_total . '.';
                $order->cost_total = $cost_total;
                $is_modified = true;
            }
        }

        $order->is_modified = $is_modified;
        if ($order->status == Order::STATUS_COMPLETED && !$order->isCompleted()) {
            $order->completed_at = now();
        }
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

    public function destroy($id, Request $request)
    {
        if ($id == 'batch') {
            $ids = $request->input('ids', []);
            $this->repository()->whereKey($ids)->get()->each->delete();
        } else {
            $this->repository()->findOrFail($id)->delete();
        }

        return json_success();
    }

    public function options()
    {
        return json_success([
            'status_options' => trans('order.status_options')
        ]);
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
        $metas = collect($item->meta_data ?? []);
        if ($item->product && !$metas->isEmpty()) {
            if ($metas->get('purchase_via') == 'point') {
                $points = $item->product->point_price * $item->quantity;
            }
        }

        return $points;
    }

    /**
     * @param Order $order
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function createPaypalOrder(Order $order)
    {
        $shipping = $order->shipping ?: [];
        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'value' => $order->total,
                        'currency_code' => 'EUR',
//                        'breakdown' => [
//                            'item_total' => [
//                                'currency_code' => 'EUR',
//                                'value' => format_amount($item_total),
//                            ],
//                            'shipping' => [
//                                'currency_code' => 'EUR',
//                                'value' => $shipping_total,
//                            ],
//                            'handling' => [
//                                'currency_code' => 'EUR',
//                                'value' => format_amount($total - $item_total - $shipping_total),
//                            ],
//                        ],
                    ],
                    //'items' => $items
                ],
            ],
            'payment_source' => [
                'paypal' => [
                    'experience_context' => [
                        'brand_name' => 'Noodlebox',
                        'landing_page_type' => 'LOGIN',
                        'user_action' => 'PAY_NOW',
                        'return_url' => route('paypal.return'),
                        'cancel_url' => route('paypal.cancel'),
                    ],
                    //'email_address' => '',
                    'name' => [
                        'given_name' => $shipping['first_name'] ?? '',
                        'surname' => $shipping['last_name'] ?? '',
                    ],
                    'address' => [
                        'address_line_1' => $shipping['address_line_1'] ?? '',
                        'address_line_2' => $shipping['address_line_2'] ?? '',
                        'admin_area_2' => $shipping['city'] ?? '',
                        'admin_area_1' => $shipping['state'] ?? '',
                        'postal_code' => $shipping['zpostal_code'] ?? '',
                        'country_code' => 'IE',
                    ]
                ],
            ],
        ];

        //return $data;
        try {
            $json = Paypal::createOrder($data);
            $res = json_decode($json, true);
            $order->out_trade_no = $res['id'] ?? '';
            $order->save();

            return $res;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }
}