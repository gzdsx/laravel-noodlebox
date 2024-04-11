<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function index(Request $request, $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(Request $request, $driver)
    {
        $oauth_user = Socialite::driver($driver)->user();

        $connect = UserConnect::where([
            'openid' => $oauth_user->getId(),
            'platform' => $driver
        ])->first();

        if ($connect) {
            $user = $connect->user()->firstOrNew();
            if (!$user->nickname){
                $user->nickname = $oauth_user->getName();
            }
            $user->save();
        } else {
            $user = new User();
            $user->nickname = $oauth_user->getName();
            $user->avatar = $oauth_user->getAvatar();
            $user->email = $oauth_user->getEmail();
            $user->avatar = $oauth_user->getAvatar();
            $user->save();

            UserConnect::create([
                'user_id' => $user->id,
                'openid' => $oauth_user->getId(),
                'platform' => $driver,
                'nickname' => $oauth_user->getNickname(),
                'avatar' => $oauth_user->getAvatar(),
            ]);
        }

        Auth::login($user);
        return redirect()->intended(session('redirect', url()->previous()));
    }
}
