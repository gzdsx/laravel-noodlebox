<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2019 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: https://www.gzdsx.cn
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2019-06-04
 * Time: 19:39
 */

// 用户认证
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::get('login/appcode', 'LoginController@appcode');
    Route::get('login/chklogin', 'LoginController@chklogin');
    Route::post('login', 'LoginController@login');
    Route::post('login/sms', 'LoginController@loginWithSms')->name('login.sms');
    Route::get('logout', 'LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'RegisterController@index')->name('register');
    Route::post('register', 'RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    Route::get('auth/{driver}', 'SocialiteController@index');
    Route::get('auth/{driver}/callback', 'SocialiteController@callback');

    Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('/email/verification-notification', 'VerificationController@resend')->name('verification.resend');

    Route::get('/forbidden', function () {
        return view('auth.forbidden');
    })->name('verification.forbidden');
});
