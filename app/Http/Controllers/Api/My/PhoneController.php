<?php

namespace App\Http\Controllers\Api\My;

use App\Models\Captcha;
use App\Models\UserPhone;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class PhoneController extends BaseController
{
    public function check(Request $request)
    {
        $request->validate([
            'national_number' => 'required|numeric',
            'phone_number' => 'required|string',
        ]);

        $national_number = $request->input('national_number');
        $phone_number = $request->input('phone_number');
        $verified = UserPhone::checkPhoneNumber(auth()->id(), $phone_number, $national_number);

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
        if (substr($phone_number, 0, 1) != '0') {
            $phone_number = '0' . $phone_number;
        }
        $phone_address = $national_number . ltrim($phone_number, '0');

        if ($verify = Captcha::wherePhone($phone_address)->orderByDesc('id')->first()) {
            if ($verify->code == $vercode) {
                $attributes = [
                    'user_id' => auth()->id(),
                    'phone_number' => $phone_number,
                    'national_number' => $national_number
                ];

                $user_phone = UserPhone::firstOrNew($attributes);
                $user_phone->verified_at = now();
                $user_phone->save();

                return json_success();
            }
        }

        return json_error(__('validation.custom.vercode.incorrect'), 422);
    }
}
