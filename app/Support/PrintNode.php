<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class PrintNode
{
    protected static $apiKey;
    protected static $baseUrl = 'https://api.printnode.com';

    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    public static function getApiKey()
    {
        return self::$apiKey;
    }

    public static function getBaseUrl()
    {
        return self::$baseUrl;
    }


    public static function createPrintJob($data)
    {
        return Http::withToken(base64_encode(self::$apiKey . ':'), 'Basic')->withHeaders([
            'Content-Type' => 'application/json'
        ])->post(self::$baseUrl . '/printjobs', $data);
    }
}