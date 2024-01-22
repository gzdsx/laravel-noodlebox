<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function verCodeLogin(Request $request)
    {
        $code = $request->input('code');
        $phone = $request->input('phone');

        if ($verify = UserVerify::wherePhone($phone)->orderByDesc('id')->first()) {
            if ($code == $verify->code) {
                if (!$user = User::wherePhone($phone)->first()) {
                    $user = new User();
                    $user->phone = $phone;
                    $user->save();
                }

                return json_success([
                    'access_token' => $user->createToken('weapp', ['*'])->accessToken,
                    'user' => $user
                ]);
            }
        }

        return json_success(500, '验证码错误');
    }
}
