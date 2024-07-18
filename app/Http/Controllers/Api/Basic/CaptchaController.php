<?php

namespace App\Http\Controllers\Api\Basic;

use App\Models\Captcha;
use App\Support\BulkSMS;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaptchaController extends BaseController
{
    public function sendSms(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'national_number' => 'required|string'
        ]);
        $phone_number = $request->input('phone_number');
        $national_number = $request->input('national_number');

        $phone_number = preg_replace("/\s/", '', ltrim($phone_number, '0'));
        $address = $national_number . $phone_number;
        $address = preg_replace("/\s/", '', $address);
        try {
            $code = mt_rand(100, 999) . mt_rand(100, 999);
            BulkSMS::sendSms([
                'from' => 'NoodleBox',
                'to' => '+' . $address,
                'body' => "【NoodleBox】{$code} is your verification code, please do not disclose it to others."
            ]);

            $captcha = Captcha::wherePhone($address)->firstOrNew();
            $captcha->phone = $address;
            $captcha->code = $code;
            $captcha->save();
            return json_success();
        } catch (\Exception $e) {
            return json_error($e->getMessage(), 422);
        }
    }

    public function sendEmail(Request $request)
    {

    }
}
