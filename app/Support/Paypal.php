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
            $response = $client->request('POST', self::getApiUrl('v1/oauth2/token'), [
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
        return self::request('POST', 'v2/checkout/orders', [
            'json' => $data,
        ]);
    }

    /**
     * @param $orderId
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function captureOrder($orderId)
    {
        return self::request('POST', "v2/checkout/orders/$orderId/capture");
    }

    /**
     * @param $method
     * @param $uri
     * @param $options
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function request($method, $uri, $options = [])
    {
        try {
            $client = new Client();
            $options['headers'] = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . self::getAccessToken(),
            ];
            $response = $client->request($method, self::getApiUrl($uri), $options);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                cache()->forget('paypalAccessToken');
            }

            abort($e->getCode(), $e->getMessage());
        }
    }

    public static function getClientId()
    {
        return self::$clientId;
    }
}