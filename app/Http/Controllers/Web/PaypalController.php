<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserPrepay;
use App\Support\Paypal;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class PaypalController extends BaseController
{
    public function capture(Request $request)
    {
        $payer_id = $request->input('PayerID');
        $orderId = $request->input('token');
        $prepay = UserPrepay::wherePaymentId($orderId)->firstOrFail();
        $order = Order::findOrFail($prepay->payable_id);
        if ($order->isPaid()){
            return redirect('orders/' . $order->id);
        }

        try {
            $json = Paypal::captureOrder($orderId);
            $data = json_decode($json);
            if ($data->status == 'COMPLETED') {
                $order->markAsPaid();
            }

        } catch (GuzzleException $e) {
            dd($e);
            //return $e->getMessage();
        }

        return redirect('orders/' . $order->id);
    }
}
