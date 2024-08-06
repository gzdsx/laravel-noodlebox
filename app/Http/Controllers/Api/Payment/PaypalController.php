<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Requests\OrderCreateRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ShippingZone;
use App\Support\Paypal;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaypalController extends BaseController
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

    public function createOrder(OrderCreateRequest $request)
    {
        $total = 0;
        $subtotal = 0;
        $items = Cart::where('user_id', $request->user()->id)->get();
        foreach ($items as $item) {
            $simple_total = bcmul($item->price, $item->quantity, 2);
            $subtotal = bcadd($subtotal, $simple_total, 2);
        }
        $total = bcadd($total, $subtotal, 2);

        $shipping_method = $request->input('shipping_method', Order::SHIPPING_METHOD_FLATRATE);
        $shipping_zone_id = $request->input('shipping_zone_id', 0);
        if ($shipping_method == Order::SHIPPING_METHOD_FLATRATE) {
            $zone = ShippingZone::find($shipping_zone_id);
            if (!$zone) {
                $zone = ShippingZone::first();
            }
            $total = bcadd($total, $zone->fee, 2);
        }

        $payment_method = $request->input('payment_method') ?: 'card';
        foreach ($this->getPaymentMethods() as $method) {
            if ($payment_method == $method['id']) {
                if ($method['fee'] > 0) {
                    $total = bcadd($total, $method['fee'], 2);
                }
            }
        }

        $use_points_value = $request->input('use_points_value', 0);
        if ($use_points_value > 0) {
            $exchange_rate = settings('points_exchange_rate', 1);
            $use_points_value = $this->calculatePoints($use_points_value, $subtotal);
            $use_points_amount = bcmul($use_points_value, $exchange_rate, 2);
            $total = bcsub($total, $use_points_amount, 2);
        }

        $shipping = $request->input('shipping', []);

//        $items = [];
//        $item_total = 0;
//        foreach ($request->input('items', []) as $item) {
//            $items[] = [
//                'name' => $item['title'],
//                'unit_amount' => [
//                    'currency_code' => 'EUR',
//                    'value' => format_amount($item['price'] ?? 0),
//                ],
//                'quantity' => $item['quantity'] ?? 1,
//            ];
//
//            $item_total += $item['price'] * $item['quantity'];
//        }

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'value' => $total,
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
                        'address_line_1' => $shipping['formatted_address'] ?? '',
                        'address_line_2' => $shipping['address_2'] ?? '',
                        'admin_area_2' => $shipping['city'] ?? '',
                        'admin_area_1' => $shipping['state'] ?? '',
                        'postal_code' => $shipping['postal_code'] ?? '',
                        'country_code' => 'IR',
                    ]
                ],
            ],
        ];

        //return $data;
        try {
            $json = Paypal::createOrder($data);
            return json_success(json_decode($json));
        } catch (\Exception $e) {
            return json_error($e->getMessage(), 422, $request->all());
        }
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

        return $points;
    }

    public function placeOrder(Request $request)
    {
        $order = Order::findOrFail($request->orderID);
        $shipping = $order->shipping || [];

        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'value' => $order->total,
                        'currency_code' => 'EUR',
                    ],
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
                        'address_line_1' => $shipping['formatted_address'] ?? '',
                        'address_line_2' => $shipping['address_2'] ?? '',
                        'admin_area_2' => $shipping['city'] ?? '',
                        'admin_area_1' => $shipping['state'] ?? '',
                        'postal_code' => $shipping['postal_code'] ?? '',
                        'country_code' => 'IR',
                    ]
                ],
            ],
        ];

        try {
            $res = json_decode(Paypal::createOrder($data),true);
            $order->transaction_id = $res['id'] ?? 0;
            $order->save();

            return json_success($res);
        } catch (\Exception $e) {
            return json_error($e->getMessage());
        }
    }
}
