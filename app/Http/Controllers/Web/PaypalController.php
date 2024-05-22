<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaypalController extends BaseController
{
    public function createOrder(Request $request)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://api.sandbox.paypal.com/v2/checkout/orders', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getPaypalToken(),
            ],
            'json' => [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'value' => '1.00',
                        ],
                    ],
                ],
            ],
        ]);

        return response($response->getBody()->getContents())->json();
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    protected function getPaypalToken()
    {
        return cache()->remember('paypal_token', 30000, function () {
            $client = new Client();
            $response = $client->request('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'auth' => [
                    env('PAYPAL_SANDBOX_CLIENT_ID'),
                    env('PAYPAL_SANDBOX_CLIENT_SECRET'),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());
            return $data->access_token;
        });
    }
}
