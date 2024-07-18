<?php

namespace App\Http\Controllers\Api\Payment;

use App\Support\Paypal;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaypalController extends BaseController
{
    public function createOrder(Request $request)
    {
        $total = $request->input('total', 0);
        $shipping_total = $request->input('shipping_line.total', 0);
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
                        'address_line_1' => $shipping['address_line_1'] ?? '',
                        'address_line_2' => $shipping['address_line_2'] ?? '',
                        'admin_area_2' => $shipping['city'] ?? '',
                        'admin_area_1' => $shipping['state'] ?? '',
                        'postal_code' => $shipping['zpostal_code'] ?? '',
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
