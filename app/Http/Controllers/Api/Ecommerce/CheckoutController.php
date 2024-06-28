<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    public function getSettings()
    {
        return json_success([
            'currency' => settings('currency', 'EUR'),
            'currency_symbol' => settings('currency_symbol', '$'),
            'currency_position' => settings('currency_position', 'left'),
            'tax_rate' => settings('tax_rate', 0),
            'tax_type' => settings('tax_type', 'exclusive'),
            'shipping_type' => settings('shipping_type', 'flat_rate'),
            'shipping_flat_rate' => settings('shipping_flat_rate', 1),
            'shipping_free_shipping' => settings('shipping_free_shipping', 0),
            'enable_points_checkout' => settings('enable_points_checkout', 'no')
        ]);
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
        $total = 0;
        $subtotal = 0;

        $items = [];
        $cart_items = Cart::with(['product'])->where('user_id', auth()->id())->get();
        foreach ($cart_items as $cart_item) {
            $purchase_via = $cart_item->getMeta('purchase_via');
            if ($purchase_via == 'point' || $purchase_via == 'lottery') {
                $items[] = [
                    'product_id' => $cart_item->product_id,
                    'title' => $cart_item->title,
                    'image' => $cart_item->image,
                    'price' => format_amount(0),
                    'quantity' => $cart_item->quantity,
                    'meta_data' => $cart_item->meta_data,
                    'total' => format_amount(0),
                ];
            } else {
                $items[] = [
                    'product_id' => $cart_item->product_id,
                    'title' => $cart_item->title,
                    'image' => $cart_item->image,
                    'price' => $cart_item->price,
                    'quantity' => $cart_item->quantity,
                    'meta_data' => $cart_item->meta_data,
                    'total' => $cart_item->total,
                ];
                $subtotal += $cart_item->total;
            }
        }
        $total += $subtotal;

        $shipping_total = 0;
        $shipping_line = $request->input('shipping_line', []);
        if (isset($shipping_line['method_id']) && $shipping_line['method_id'] == 'flat_rate') {
            $zone = ShippingZone::find($shipping_line['zone_id'] ?? 0);
            if ($zone) {
                $shipping_line['total'] = $zone->fee;
                $shipping_total = $zone->fee;
            }
        } else {
            $shipping_line['total'] = format_amount(0);
        }
        $total += $shipping_total;

        $fee_lines = [];
        $payment_method = $request->input('payment_method', 'online');
        if ($payment_method == 'online' || $payment_method == 'card') {
            $fee_lines[] = [
                'name' => 'Payment Fee',
                'total' => format_amount(0.5)
            ];
            $total += 0.5;
        }

        $discount_total = 0;
        $discount_lines = [];
        $meta_data = $request->input('meta_data', []);
        if (isset($meta_data['use_points_value']) && $meta_data['use_points_value'] > 0) {
            $use_points_amount = $meta_data['use_points_value'] * settings('points_exchange_rate', 1);
            $discount_lines[] = [
                'name' => 'Points',
                'total' => format_amount($use_points_amount),
            ];
            $discount_total += $use_points_amount;
        }

        $total -= $discount_total;

        $shipping = auth()->user()->getMeta('shipping_address', []);

        return json_success([
            'items' => $items,
            'shipping_line' => $shipping_line,
            'shipping_total' => $shipping_total,
            'fee_lines' => $fee_lines,
            'discount_lines' => $discount_lines,
            'discount_total' => format_amount($discount_total),
            'total' => format_amount($total),
            'subtotal' => format_amount($subtotal),
            'tax_total' => 0,
            'shipping' => $shipping,
            'settings' => [
                'currency' => settings('currency', 'EUR'),
                'currency_symbol' => settings('currency_symbol', '$'),
                'currency_position' => settings('currency_position', 'left'),
                'tax_rate' => settings('tax_rate', 0),
                'tax_type' => settings('tax_type', 'exclusive'),
                'shipping_type' => settings('shipping_type', 'flat_rate'),
                'shipping_flat_rate' => settings('shipping_flat_rate', 1),
                'shipping_free_shipping' => settings('shipping_free_shipping', 0),
                'enable_points_checkout' => settings('enable_points_checkout', 'no')
            ]
        ]);
    }
}
