<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use App\Models\UserConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppleController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $openid = $request->input('openid');
            $connect = UserConnect::findByOpenid($openid);
            if ($connect) {
                $user = $connect->user;
            } else {
                $user = new User();
                $user->email = $request->input('email');
                $user->nickname = $request->input('nickname') ?: 'apple_user_' . Str::random(6);
                $user->save();

                $connect = new UserConnect();
                $connect->openid = $openid;
                $connect->platform = 'apple';
                $connect->nickname = $user->nickname;
                $connect->user()->associate($user);
                $connect->save();
            }

            $access_token = $user->createToken('apple')->accessToken;
            return json_success(['access_token' => $access_token]);
        });
    }
}
