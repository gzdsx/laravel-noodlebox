<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Traits\Auth\UserLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use UserLogin;

    public function username()
    {
        return 'phone_number';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'password' => 'required|string|pwd',
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');

        $check = $this->guard()->attempt([
            'phone_number' => $account,
            'password' => $password
        ], $request->filled('remember'));

        if ($check) {
            return true;
        }

        return $this->guard()->attempt([
            'email' => $account,
            'password' => $password
        ], $request->filled('remember'));
    }

    protected function sendLoginResponse(Request $request)
    {
        $capability = $this->guard()->user()->getMeta('capability');
        if ($capability == 'administrator' || $capability == 'manager') {
            $access_token = $this->guard()->user()->createToken('admin')->accessToken;
            $capability = $this->guard()->user()->getMeta('capability');
            return json_success(compact('access_token', 'capability'));
        }

        abort(403, trans('auth.failed'));
    }
}
