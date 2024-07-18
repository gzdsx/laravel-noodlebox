<?php

namespace App\Http\Controllers\Api\Ecommerce;

use App\Models\Cart;
use App\Models\Order;
use App\Models\UserPrepay;
use App\Support\Paypal;
use App\Traits\RestApis\OrderApis;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    use OrderApis;

    public function capture(Request $request, $orderId)
    {
        $prepay = UserPrepay::wherePaymentId($orderId)->firstOrFail();
        $order = Order::findOrFail($prepay->payable_id);
        if ($order->isUnPaid()) {
            try {
                $json = Paypal::captureOrder($orderId);
                $data = json_decode($json);
                if ($data->status == 'COMPLETED') {
                    $order->markAsPaid();
                }

            } catch (GuzzleException $e) {
                return json_error($e->getMessage());
            }
        }

        return json_success($order);
    }

    public function purchase($id)
    {
        $order = Order::findOrFail($id);
        foreach ($order->items as $item) {
            if (isset($item->meta_data['purchase_via']) && $item->meta_data['purchase_via'] == 'lottery') {
                continue;
            }

            $cart = new Cart();
            $cart->user_id = auth()->id();
            $cart->shop_id = $order->shop_id;
            $cart->product_id = $item->product_id;
            $cart->title = $item->title;
            $cart->image = $item->image;
            $cart->price = $item->price;
            $cart->quantity = $item->quantity;
            $cart->sku_id = $item->sku_id;
            $cart->sku_title = $item->sku_title;
            $cart->meta_data = [
                'options' => $item->meta_data['options'] ?? [],
                'additional_options' => $item->meta_data['additional_options'] ?? [],
            ];
            $cart->purchase_via = 'order';
            $cart->save();
        }

        return json_success($order);
    }
}
