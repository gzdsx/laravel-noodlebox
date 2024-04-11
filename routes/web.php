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

Route::namespace('H5')->prefix('h5')->group(function () {
    Route::get('/', 'IndexController@index');
});

Route::namespace('Web')->group(function () {
    Route::get('/', 'IndexController@index');
    Route::get('payment/paypal', 'PaymentController@paypal');
    Route::get('vue-admin', 'AdminController@index');
    Route::get('search', 'SearchController@index');
    Route::get('post/{cate?}', 'PostController@index')->where('cate', '[0-9]+');
    Route::get('post/{slug}', 'PostController@show');

    Route::get('product/{slug}', 'ProductController@show');
    Route::get('category/{slug}', 'ProductController@category');

    Route::get('points-mall', 'PointsMallController@index')->name('points-mall');
    Route::get('cart', 'CartController@index')->name('cart')->middleware('auth');
    Route::get('checkout', 'CheckoutController@index')->name('checkout')->middleware('auth');
    Route::get('home', 'HomeController@index')->name('home')->middleware('auth');
    Route::get('orders/{id}', 'OrderController@show')->name('home')->middleware('auth');

    Route::get('my-account', 'MyAccountController@index')->name('my-account')->middleware('auth');
    Route::get('my-account/orders', 'OrderController@index')->name('my-orders')->middleware('auth');

    Route::get('pos', 'PosController@index')->name('pos')->middleware('auth');
    Route::get('{page}', 'PageController@show')->where('page', '[a-zA-Z0-9_\-]+');
});