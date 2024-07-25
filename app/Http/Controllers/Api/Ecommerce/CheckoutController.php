<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderMeta;
use App\Models\ShippingZone;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Support\Paypal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        return $points;
    }

    public function order(Request $request)
    {
        $total = 0;
        $subtotal = 0;
        $items = Cart::with(['product'])->where('user_id', $request->user()->id)->get();
        foreach ($items as $item) {
            $simple_total = bcmul($item->price, $item->quantity, 2);
            $subtotal = bcadd($subtotal, $simple_total, 2);
        }
        $total = bcadd($total, $subtotal, 2);

        $shipping_total = 0;
        $shipping_method = $request->input('shipping_method', Order::SHIPPING_METHOD_FLATRATE);
        $shipping_zone_id = $request->input('shipping_zone_id', 0);
        if ($shipping_method == Order::SHIPPING_METHOD_FLATRATE) {
            $zone = ShippingZone::find($shipping_zone_id);
            if (!$zone) {
                $zone = ShippingZone::first();
                $shipping_zone_id = $zone->id;
            }
            $shipping_total = bcadd($shipping_total, $zone->fee, 2);
        } else {
            $shipping_total = bcadd($shipping_total, '0', 2);
        }
        $total = bcadd($total, $shipping_total, 2);

        $fee_lines = [];
        $payment_method = $request->input('payment_method') ?: 'online';
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

        $discount_lines = [];
        $use_points_value = $request->input('use_points_value', 0);
        if ($use_points_value > 0) {
            $exchange_rate = settings('points_exchange_rate', 1);
            $use_points_value = $this->calculatePoints($use_points_value, $subtotal, 2);
            $use_points_amount = bcmul($use_points_value, $exchange_rate, 2);
            $discount_lines[] = [
                'name' => 'Points deduction',
                'total' => $use_points_amount
            ];
            $total = bcsub($total, $use_points_amount, 2);
        }

        $shipping = $request->input('shipping', []);
        if (!isset($shipping['first_name']) || blank($shipping['first_name'])) {
            $shipping = $request->user()->getMeta('shipping_address', []);
        }

        return json_success(compact(
            'items',
            'total',
            'subtotal',
            'shipping',
            'shipping_total',
            'shipping_method',
            'shipping_zone_id',
            'payment_method',
            'fee_lines',
            'discount_lines',
            'use_points_value'
        ));
    }

    public function options()
    {
        $in_delivery_hours = false;
        $hour_start = Carbon::createFromTimeString(settings('delivery_hours_start', '09:00'));
        $hour_end = Carbon::createFromTimeString(settings('delivery_hours_end', '09:00'));

        if (now()->lte($hour_end) || now()->gte($hour_start)) {
            $in_delivery_hours = true;
        }

        return $this->success([
            'currency' => settings('currency', 'EUR'),
            'currency_symbol' => settings('currency_symbol', '€'),
            'enable_points_checkout' => settings('enable_points_checkout', 'no'),
            'shipping_methods' => $this->shipping_methods,
            'shipping_zones' => ShippingZone::all(),
            'payment_methods' => $this->getPaymentMethods(),
            'paypal_client_id' => Paypal::getClientId(),
            'in_delivery_hours' => $in_delivery_hours,
            'order_warning' => settings('shop_order_warning')
        ]);
    }
}
