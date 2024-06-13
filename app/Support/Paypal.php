<?php

namespace App\Support;

use GuzzleHttp\Client;

class Paypal
{
    protected static $clientId;
    protected static $clientSecret;
    protected static $sandbox = true;

    public static function init($clientId, $clientSecret, $sandbox = true)
    {
        self::$clientId = $clientId;
        self::$clientSecret = $clientSecret;
        self::$sandbox = $sandbox;
    }

    /**
     * @param $path
     * @return string
     */
    public static function getApiUrl($path)
    {
        $path = ltrim($path, '/');
        return self::$sandbox ? "https://api-m.sandbox.paypal.com/$path" : "https://api-m.paypal.com/$path";
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function getAccessToken()
    {
        return cache()->remember('paypalAccessToken', 30000, function () {
            $client = new Client();
            $response = $client->request('POST', Paypal::getApiUrl('v1/oauth2/token'), [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
                'auth' => [
                    self::$clientId,
                    self::$clientSecret,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());
            return $data->access_token;
        });
    }

    /**
     * @param $data
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function createOrder($data)
    {
        $client = new Client();
        $response = $client->request('POST', self::getApiUrl('v2/checkout/orders'), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . self::getAccessToken(),
            ],
            'json' => $data,
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * @param $orderId
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function captureOrder($orderId){
        $client = new Client();
        $response = $client->request('POST', self::getApiUrl('v2/checkout/orders/'.$orderId.'/capture'), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . self::getAccessToken(),
            ],
        ]);

        return $response->getBody()->getContents();
    }
}