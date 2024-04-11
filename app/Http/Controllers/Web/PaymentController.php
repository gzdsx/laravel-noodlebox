<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Models\UserPrepay;
use GuzzleHttp\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    public function paypal(Request $request)
    {
        $payer_id = $request->input('PayerID');
        $payment_id = $request->input('paymentId');
        if (env('PAYPAL_ENV') == 'sandbox') {
            $auth = [
                env('PAYPAL_SANDBOX_CLIENT_ID'),
                env('PAYPAL_SANDBOX_CLIENT_SECRET')
            ];
            $apiUrl = 'https://api-m.sandbox.paypal.com/v1/payments/payment/' . $payment_id . '/execute';
            //$apiUrl = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
        } else {
            $auth = [
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_CLIENT_SECRET')
            ];
            $apiUrl = 'https://api-m.paypal.com/v1/payments/payment' . $payment_id . '/execute';
            //$apiUrl = 'https://api-m.paypal.com/v2/checkout/orders';
        }

        try {
            $client = new Client();
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'auth' => $auth,
                'json' => [
                    'payer_id' => $payer_id,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            if ($data->state == 'approved') {
                $prepay = UserPrepay::where('payment_id', $payment_id)->firstOrFail();
                if ($prepay->payable_id) {
                    $order = Order::find($prepay->payable_id);
                    $order->markAsPaid();
                }

                return redirect('orders/' . $order->order_id);
            } else {
                abort(500, 'unpaid');
            }

        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
