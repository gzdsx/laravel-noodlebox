<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function info()
    {
        $user = Auth::user();
        return json_success([
            'id' => $user->id,
            'nickname' => $user->nickname,
            'avatar' => $user->avatar,
            'email' => $user->email,
            'phone' => $user->national_number . $user->phone_number,
            'gender' => $user->getMeta('gender'),
            'country' => $user->getMeta('country'),
            'city' => $user->getMeta('city')
        ]);
    }
}
