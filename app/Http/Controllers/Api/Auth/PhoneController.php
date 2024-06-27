<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Captcha;
use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneController extends BaseController
{
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
            'national_number' => 'required|numeric',
            'vercode' => 'required|string|max:6',
        ]);

        $code = $request->input('vercode');
        $phone_number = $request->input('phone_number', '');
        $national_number = $request->input('national_number', '353');

        $phone_number = preg_replace("/\s/", '', $phone_number);
        $address = $national_number . ltrim($phone_number, '0');
        if ($captcha = Captcha::wherePhone($address)->orderByDesc('id')->first()) {
            if ($code == $captcha->code) {
                $attributes = [
                    'phone_number' => $phone_number,
                    'national_number' => $national_number
                ];

                if (!$user = User::where($attributes)->first()) {
                    $user = new User();
                    $user->fill($attributes);
                    $user->nickname = $phone_number;
                    $user->save();
                }

                $user_phone = UserPhone::firstOrCreate($attributes)->firstOrNew();
                $user_phone->verified_at = now();
                $user_phone->user()->associate($user);
                $user_phone->save();

                return json_success([
                    'access_token' => $user->createToken('api')->accessToken
                ]);
            }

            return json_error(__('validation.custom.vercode.incorrect'), 422);
        }

        return json_error('code not found', 404, $address);
    }
}
