<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Support\Paypal;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class PaypalController extends BaseController
{
    public function capture(Request $request)
    {
        $transaction_id = $request->input('token');
        $order = Order::whereTransactionId($transaction_id)->firstOrFail();
        if (!$order->isPaid()){
            try {
                $json = Paypal::captureOrder($transaction_id);
                $data = json_decode($json);
                if ($data->status == 'COMPLETED') {
                    $order->markAsPaid();
                }

            } catch (GuzzleException $e) {
                return view('web.message',[
                    'title' => 'Order Paid Failed',
                    'message' => 'Your order has not been paid yet.',
                ]);
            }
        }

        return view('web.message',[
            'title' => 'Order Paid Success',
            'message' => 'Your order has been paid successfully.',
        ]);
    }

    public function cancel(Request $request)
    {
        $transaction_id = $request->input('token');
        $order = Order::whereTransactionId($transaction_id)->firstOrFail();
        if (!$order->isPaid()){
            $order->forceDelete();
        }

        return view('web.message',[
            'title' => 'Order cancel success',
            'message' => 'Your order has been cancelled.',
        ]);
    }
}
