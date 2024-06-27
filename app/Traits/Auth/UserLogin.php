<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2021 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: https://www.gzdsx.cn
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2021/1/20
 * Time: 05:26
 */

namespace App\Traits\Auth;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

trait UserLogin
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'email';
    }

    /**
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string|pwd',
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return $this->guard()->attempt([
            'email' => $email,
            'password' => $password
        ], $request->filled('remember'));
    }
}
