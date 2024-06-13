<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Support\Paypal;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaypalController extends BaseController
{
    public function createOrder(Request $request)
    {
        try {
            $json = Paypal::createOrder($request->input('orderData', []));
            return json_success(json_decode($json));
        } catch (\Exception $e) {
            return json_error($e->getMessage(), 500, $request->input('orderData', []));
        }
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
