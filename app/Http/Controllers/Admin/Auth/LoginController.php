<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Traits\Auth\UserLogin;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use UserLogin;
    protected function sendLoginResponse(Request $request)
    {
        if ($this->guard()->user()->isAdmin()) {
            $access_token = $this->guard()->user()->createToken('admin')->accessToken;

            return json_success(compact('access_token'));
        }

        abort(403);
    }
}
