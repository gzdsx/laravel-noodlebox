<?php

namespace App\Http\Controllers\Api\Basic;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\UserPhone;
use App\Models\Captcha;
use Illuminate\Http\Request;

class PhoneController extends BaseController
{
    public function check(Request $request)
    {
        $phone_number = $request->input('phone_number');
        $national_number = $request->input('national_number');

        if (!$phone_number) {
            return json_success(false);
        }

        $verified = UserPhone::where([
            'national_number' => $national_number,
            'phone_number' => $phone_number,
        ])->exists();

        return json_success($verified);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'national_number' => 'required|numeric',
            'vercode' => 'required|numeric',
        ]);

        $phone_number = $request->input('phone_number');
        $national_number = $request->input('national_number');
        $vercode = $request->input('vercode');

        $phone_number = preg_replace("/\s/", '', $phone_number);
        $address = $national_number . ltrim($phone_number, '0');

        if ($verify = Captcha::wherePhone($address)->orderByDesc('id')->first()) {
            if ($verify->code == $vercode) {
                $attributes = [
                    'phone_number' => $phone_number,
                    'national_number' => $national_number
                ];

                $user_phone = UserPhone::firstOrCreate($attributes)->firstOrNew();
                $user_phone->verified = 1;
                $user_phone->save();

                return json_success();
            }
        }

        return json_error(__('validation.custom.vercode.incorrect'), 422);
    }
}
