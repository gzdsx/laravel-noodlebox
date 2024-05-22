<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaypalController extends BaseController
{
    public function createOrder(Request $request)
    {
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://api.sandbox.paypal.com/v2/checkout/orders', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->getPaypalToken(),
                    'PayPal-Request-Id' => '7b92603e-77ed-4896-8e78-5dea2050476a'
                ],
                'json' => [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'value' => '1.00',
                                'currency_code' => 'EUR'
                            ],
                        ],
                    ],
                    'payment_source' => [
                        'paypal' => [
                            'experience_context' => [
                                'payment_method_preference' => 'IMMEDIATE_PAYMENT_REQUIRED',
                                'payment_method_selected' => 'PAYPAL',
                                'landing_page_type' => 'BILLING',
                                'user_action' => 'CONTINUE',
                                'return_url' => 'https://example.com/return',
                                'cancel_url' => 'https://example.com/cancel'
                            ],
                            'name' => [
                                'given_name' => 'paypal',
                                'surname' => 'paypal'
                            ],
                            'email_address' => 'paypal@example.com',
                            'phone' => [
                                'phone_type' => 'MOBILE',
                                'phone_number' => [
                                    'national_number' => '18685849696'
                                ]
                            ],
                            'address' => [
                                'address_line_1' => 'zhong yang da jie',
                                'address_line_2' => 'line2',
                                'admin_area_2' => 'qianan',
                                'admin_area_1' => 'Guizhou',
                                'postal_code' => '12345',
                                'country_code' => 'IR'
                            ]
                        ],
//                        'card' => [
//                            'name' => 'card',
//                            'number' => '4111111111111111',
//                            'expiry' => '2021-01',
//                        ],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());
            return json_success($data);
        } catch (\Exception $e) {
            return json_error($e->getMessage(), 422);
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
