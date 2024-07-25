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

Route::get('admin', function () {
    return view('admin.index');
});

Route::get('vue-admin', function () {
    return view('admin.index');
});

Route::get('vue-admin/login', function () {
    return view('admin.login');
});

Route::namespace('Web')->group(function () {
    Route::get('/', 'IndexController@index');
    Route::get('post/{cate?}', 'PostController@index')->where('cate', '[0-9]+');
    Route::get('post/{slug}', 'PostController@show');
    Route::get('product/{slug}', 'ProductController@show');
    Route::get('category/{slug}', 'ProductController@category');
    Route::get('points-mall/{slug?}', 'PointsMallController@index')->name('points-mall');
    Route::get('cart', 'CartController@index')->name('cart')->middleware(['auth']);
    Route::get('checkout', 'CheckoutController@index')->name('checkout')->middleware(['auth']);
    Route::get('orders/{id}', 'OrderController@show')->name('order.show')->middleware(['auth']);

    Route::get('home', 'MyAccountController@index')->name('home')->middleware(['auth']);
    Route::get('my-account', 'MyAccountController@index')->name('my-account')->middleware(['auth']);
    Route::get('my-account/address', 'MyAccountController@address')->name('my-account.address')->middleware(['auth']);
    Route::get('my-account/points', 'MyAccountController@points')->name('my-account.points')->middleware(['auth']);

    Route::get('paypal/return', 'PaypalController@capture')->name('paypal.return');
    Route::get('paypal/cancel', 'PaypalController@capture')->name('paypal.cancel');

    Route::get('invoice/order/{id?}', 'InvoiceController@order')
        ->name('invoice.order')->middleware('signed');
    Route::get('invoice/cashier/billing/{id?}', 'InvoiceController@cashierBilling')
        ->name('invoice.cashier.billing')->middleware('signed');
    Route::get('invoice/cashier/transaction/{id?}', 'InvoiceController@cashierTransaction')
        ->name('invoice.cashier.transaction')->middleware('signed');
    Route::get('invoice/deliveryer/{id}/report', 'InvoiceController@DeliveryerBilling')
        ->name('invoice.deliveryer.report')->middleware('signed');
    Route::get('invoice/deliveryer/transaction/{id?}', 'InvoiceController@deliveryerTransaction')
        ->name('invoice.deliveryer.transaction')->middleware('signed');

    Route::get('pos', 'PosController@index')->name('pos')->middleware(['auth', 'verified']);
    Route::get('{page}', 'PageController@show')->where('page', '[a-zA-Z0-9_\-]+');
});
