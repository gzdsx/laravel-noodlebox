<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderMeta;
use App\Models\ShippingZone;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    protected $shipping_methods = [
        [
            'id' => 'flat_rate',
            'title' => 'Delivery',
        ],
        [
            'id' => 'local_pickup',
            'title' => 'Collection',
        ]
    ];

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

    protected function calculatePoints($points, $subtotal)
    {
        $user = auth()->user();
        $exchange_rate = settings('points_exchange_rate', 1);

        if ($points > $user->points) {
            $points = $user->points;
        }

        $max_points = floor($subtotal / $exchange_rate);
        if ($points > $max_points) {
            $points = $max_points;
        }

        return [
            'points' => $points,
            'points_total' => $points * $exchange_rate,
        ];
    }

    public function usePoints(Request $request)
    {
        $user = auth()->user();
        $points = $request->input('points', 0);
        $subtotal = $request->input('subtotal', 0);
        $exchange_rate = settings('points_exchange_rate', 1);

        if ($points > $user->points) {
            $points = $user->points;
        }

        $max_points = floor($subtotal / $exchange_rate);
        if ($points > $max_points) {
            $points = $max_points;
        }

        return json_success([
            'points' => $points,
            'points_total' => $points * $exchange_rate,
            'points_remain' => $user->points - $points,
            'exchange_rate' => $exchange_rate
        ]);
    }

    public function order(Request $request)
    {
        $user = $request->user();
        $order = new Order();
        $order->total = 0;

        $items = Cart::with(['product'])->where('user_id', $user->id)->get();
        foreach ($items as $item) {
            $order->items->push(new OrderItem([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'title' => $item->title,
                'image' => $item->image,
                'meta_data' => $item->meta_data,
                'total' => $item->quantity * $item->price,
            ]));
        }
        $order->total += $order->subtotal;

        $shipping_total = 0;
        $shipping_line = $request->input('shipping_line', []);
        $shipping_method = $request->input('shipping_method', Order::SHIPPING_METHOD_FLATRATE);

        foreach ($this->shipping_methods as $method) {
            if ($method['id'] == $shipping_method) {
                $shipping_line['method_id'] = $method['id'];
                $shipping_line['method_title'] = $method['title'];
            }
        }

        if ($shipping_method == Order::SHIPPING_METHOD_FLATRATE) {
            $zone_id = $shipping_line['zone_id'] ?? 0;
            if ($zone_id) {
                $zone = ShippingZone::find($zone_id);
            } else {
                $zone = ShippingZone::first();
            }

            if ($zone) {
                $shipping_line['zone_id'] = $zone->id;
                $shipping_line['zone_title'] = $zone->title;
                $shipping_line['total'] = $zone->fee;
                $shipping_total = $zone->fee;
            } else {
                $shipping_line['total'] = '0.00';
            }
        } else {
            $shipping_line['total'] = '0.00';
            $shipping_line['zone_id'] = null;
            $shipping_line['zone_title'] = null;
        }
        $order->total += $shipping_total;
        $order->shipping_total = $shipping_total;
        $order->shipping_line = $shipping_line;
        $order->shipping_method = $shipping_method;

        $fee_lines = [];
        $payment_method = $request->input('payment_method', 'online');
        foreach ($this->getPaymentMethods() as $method) {
            if ($payment_method == $method['id']) {
                $order->payment_method = $method['id'];
                $order->payment_method_title = $method['title'];

                if ($method['fee'] > 0) {
                    $fee_lines[] = [
                        'name' => 'Commission',
                        'total' => format_amount($method['fee'])
                    ];
                    $order->total += $method['fee'];
                }
            }
        }
        $order->fee_lines = $fee_lines;

        $discount_total = 0;
        $discount_lines = [];
        $meta_data = collect($request->input('meta_data', []));
        if ($meta_data->get('use_points_value', 0) > 0) {
            $pointData = $this->calculatePoints($meta_data->get('use_points_value', 0), $order->subtotal);
            $points = $pointData['points'];
            $points_total = $pointData['points_total'];

            $discount_lines[] = [
                'name' => 'Points',
                'total' => format_amount($points_total),
            ];
            $discount_total += $points_total;
            $meta_data->put('use_points_value', $points);
        }

        foreach ($meta_data as $key => $value) {
            $order->metas->push(new OrderMeta([
                'meta_key' => $key,
                'meta_value' => $value
            ]));
        }

        $order->discount_lines = $discount_lines;
        $order->discount_total = bcadd($discount_total, 0, 2);
        $order->total = bcsub($order->total, $discount_total, 2);

        $shipping = $request->input('shipping', []);
        if (!isset($shipping['first_name']) || empty($shipping['first_name'])) {
            $order->shipping = array_merge([
                'first_name' => '',
                'last_name' => '',
                'company' => '',
                'address_1' => '',
                'address_2' => '',
                'city' => '',
                'state' => '',
                'postcode' => '',
                'country' => 'IR',
                'national_number' => $user->national_number,
                'phone_number' => $user->phone_number,
                'email' => $user->email,
                'formatted_address' => ''
            ], $user->getMeta('shipping_address', []));
        } else {
            $order->shipping = $shipping;
        }

        return json_success($order);
    }

    public function options()
    {
        return $this->success([
            'currency' => settings('currency', 'EUR'),
            'currency_symbol' => settings('currency_symbol', '€'),
            'enable_points_checkout' => settings('enable_points_checkout', 'no'),
            'shipping_methods' => $this->shipping_methods,
            'shipping_zones' => ShippingZone::all(),
            'payment_methods' => $this->getPaymentMethods()
        ]);
    }
}
