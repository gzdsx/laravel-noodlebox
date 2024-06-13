<?php

namespace App\Support;

use GuzzleHttp\Client;

class BulkSMS
{
    protected static $username;
    protected static $password;

    public static function setCredentials($username, $password)
    {
        self::$username = $username;
        self::$password = $password;
    }

    public static function sendSms($messages)
    {
        $url = "https://api.bulksms.com/v1/messages?auto-unicode=true";
        $client = new Client();
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(self::$username . ':' . self::$password),
                'Content-Type' => 'application/json',
            ],
            'json' => $messages,
        ]);

        return $response->getBody()->getContents();
    }

    public static function showSms($id)
    {
        $url = "https://api.bulksms.com/v1/messages/{$id}";
        $client = new Client();
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(self::$username . ':' . self::$password),
                'Content-Type' => 'application/json',
            ],
        ]);

        return $response->getBody()->getContents();
    }
}