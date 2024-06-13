<?php

namespace App\Traits\RestApis;

use App\Events\OrderChanged;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingZone;
use App\Models\UserPointTransaction;
use App\Models\UserPrepay;
use App\Support\Paypal;
use App\Support\TradeUtil;
use GuzzleHttp\Client;
use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request, $id = 0)
    {
        $order = $this->repository()->findOrNew($id);
        $order->order_no = TradeUtil::createOrderNo();
        $order->out_trade_no = TradeUtil::createOutTradeNo();
        $order->payment_method = $request->input('payment_method');
        $order->payment_method_title = $request->input('payment_method_title');
        $order->shipping_method = $request->input('shipping_method');
        $order->shipping_zone_id = $request->input('shipping_zone_id');
        $order->shipping_total = $request->input('shipping_total', 0);
        $order->buyer_note = $request->input('buyer_note');
        $order->shipping = $request->input('shipping', []);
        $order->billing = $request->input('billing', []);
        $order->created_via = $request->input('created_via', 'checkout');
        $order->meta_data = $request->input('meta_data', []);
        $order->shipping_lines = $request->input('shipping_lines', []);

        $buyer = Auth::user();
        $order->buyer_id = $buyer->id;
        $order->buyer_name = $buyer->nickname;

        $total = 0;
        $fee_lines = $request->input('fee_lines', []);
        foreach ($fee_lines as $fee_line) {
            $total += $fee_line['total'] ?? 0;
        }
        $order->fee_lines = $fee_lines;

        if ($order->shipping_method == 'delivery') {
            $zone = ShippingZone::findOrFail($order->shipping_zone_id);
            $order->shipping_total = $zone->fee;
            $total += $zone->fee;
        }

        $discount_total = 0;
        $discount_lines = $request->input('discount_lines', []);
        foreach ($discount_lines as $discount_line) {
            $total -= $discount_line['total'] ?? 0;
            $discount_total += $discount_line['total'] ?? 0;
        }

        $points = $request->input('points', 0);
        if ($points > 0) {
            $points_total = $points * settings('points_exchange_rate', 0);
            $total -= $points_total;

            $buyer->points -= $points;
            $buyer->save();

            $transaction = new UserPointTransaction();
            $transaction->user_id = $buyer->id;
            $transaction->points = $points;
            $transaction->type = 2;
            $transaction->detail = 'exchange';
            $transaction->save();
        }

        $order->discount_lines = $discount_lines;
        $order->discount_total = $discount_total;
        $order->total = $total;
        $order->save();

        $point_payment_amount = 0;
        $items = $request->input('items', []);
        foreach ($items as $item) {
            $order->total += $item['price'] * $item['quantity'];
            $order->items()->create($item);
        }

        if ($point_payment_amount > 0) {
            $buyer->points -= $point_payment_amount;
            $buyer->save();

            $transaction = new UserPointTransaction();
            $transaction->user_id = $buyer->id;
            $transaction->points = $point_payment_amount;
            $transaction->type = 2;
            $transaction->detail = 'purchase';
            $transaction->save();
        }

        foreach ($order->items()->with(['product'])->get() as $item) {
            if ($item->product) {
                if ($item->product->points > 0) {
                    $points = $item->product->points * $item->quantity;
                    $buyer->points += $points;
                    $buyer->save();

                    $transaction = new UserPointTransaction();
                    $transaction->user_id = $buyer->id;
                    $transaction->points = $points;
                    $transaction->type = 2;
                    $transaction->detail = 'earn';
                    $transaction->save();
                }
            }

        }

        if ($order->payment_method == 'paypal') {
            $order->status = Order::ORDER_STATUS_PENDING;
        } else {
            $order->status = Order::ORDER_STATUS_COMPLETED;
            $order->payment_status = 1;
            $order->payment_at = now();
        }
        $order->save();
        $order->refresh();

        event(new OrderChanged($order, 'created'));

        //更新地址
        Auth::user()->updateMeta('billing_address', $order->billing);
        Auth::user()->updateMeta('shipping_address', $order->shipping);

        $model = $this->repository()->find($order->id);
        $self_link = url('orders/' . $order->id);
        $approval_link = url('orders/' . $order->id);

        /*
        if ($model->payment_method == 'paypal') {
            try {
                $shipping = collect($order->shipping);
                $jsonRes = Paypal::createOrder([
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'value' => format_amount($order->total),
                                'currency_code' => 'EUR'
                            ],
                        ],
                    ],
                    'payment_source' => [
                        'paypal' => [
                            'experience_context' => [
                                'payment_method_preference' => 'IMMEDIATE_PAYMENT_REQUIRED',
                                'payment_method_selected' => 'PAYPAL',
                                'landing_page_type' => 'BILLING',
                                'user_action' => 'CONTINUE',
                                'return_url' => route('paypal.return'),
                                'cancel_url' => route('paypal.cancel')
                            ],
                            'name' => [
                                'given_name' => $shipping->get('first_name'),
                                'surname' => $shipping->get('last_name')
                            ],
                            'email_address' => $shipping->get('email'),
                            'phone' => [
                                'phone_type' => 'MOBILE',
                                'phone_number' => [
                                    'national_number' => $shipping->get('phone')
                                ]
                            ],
                            'address' => [
                                'address_line_1' => $shipping->get('address_line_1'),
                                'address_line_2' => $shipping->get('address_line_2'),
                                'admin_area_2' => $shipping->get('city'),
                                'admin_area_1' => $shipping->get('state'),
                                'postal_code' => $shipping->get('postalcode'),
                                'country_code' => 'IR'
                            ]
                        ],
                    ],
                ]);

                $paypalData = json_decode($jsonRes, true);
                $prepay = new UserPrepay();
                $prepay->payable_id = $model->id;
                $prepay->payment_id = $paypalData['id'];
                $prepay->data = $paypalData;
                $prepay->user()->associate(Auth::id());
                $prepay->save();
                $approval_link = $paypalData['links'][1]['href'];
            } catch (\Exception $e) {
                return json_error($e->getMessage(), 422);
            }
        }
        */
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
    }
}