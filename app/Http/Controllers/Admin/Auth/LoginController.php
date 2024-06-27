<?php

namespace App\Http\Controllers\Admin\Auth;


use App\Http\Controllers\Controller;
use App\Traits\Auth\UserLogin;
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

        return $this->guard()->attempt([
            'phone_number' => $account,
            'password' => $password
        ], $request->filled('remember'));
    }

    protected function sendLoginResponse(Request $request)
    {
        if ($this->guard()->user()->isAdmin()) {
            $access_token = $this->guard()->user()->createToken('admin')->accessToken;

            return json_success(compact('access_token'));
        }

        abort(403);
    }
}
