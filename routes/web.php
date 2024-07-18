<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('test', 'Test\IndexController@index');
Route::get('table', 'Test\IndexController@table');

Route::namespace('Web')->group(function () {
    Route::get('/', 'IndexController@index');
    Route::get('vue-admin', 'AdminController@index');
    Route::get('vue-admin/login', 'AdminController@showLogin');
    Route::get('search', 'SearchController@index');
    Route::get('post/{cate?}', 'PostController@index')->where('cate', '[0-9]+');
    Route::get('post/{slug}', 'PostController@show');

    Route::get('product/{slug}', 'ProductController@show');
    Route::get('category/{slug}', 'ProductController@category');

    Route::get('points-mall', 'PointsMallController@index')->name('points-mall');
    Route::get('cart', 'CartController@index')->name('cart')->middleware(['auth', 'verified']);
    Route::get('checkout', 'CheckoutController@index')->name('checkout')->middleware(['auth', 'verified']);
    Route::get('orders/{id}', 'OrderController@show')->name('order.show')->middleware(['auth', 'verified']);
    Route::get('orders/invoice/{hashid}', 'OrderController@invoice')->name('order.invoice');

    Route::get('home', 'MyAccountController@index')->name('home')->middleware(['auth', 'verified']);
    Route::get('my-account', 'MyAccountController@index')->name('my-account')->middleware(['auth', 'verified']);
    Route::get('my-account/address', 'MyAccountController@address')->name('my-account.address')->middleware(['auth', 'verified']);
    Route::get('my-account/points', 'MyAccountController@points')->name('my-account.points')->middleware(['auth', 'verified']);

    Route::get('paypal/return', 'PaypalController@capture')->name('paypal.return');
    Route::get('paypal/cancel', 'PaypalController@capture')->name('paypal.cancel');

    Route::get('user/verify/{id}', 'UserController@verify')->name('user.verify');

    Route::get('pos', 'PosController@index')->name('pos')->middleware(['auth', 'verified']);
    Route::get('{page}', 'PageController@show')->where('page', '[a-zA-Z0-9_\-]+');
});
