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
    Route::get('post/{cate?}', 'PostController@index')->where('cate', '[0-9]+');
    Route::get('post/{slug}', 'PostController@show');

    Route::get('product/{slug}', 'ProductController@show');

    Route::get('search', 'SearchController@index');
    Route::get('{page}', 'PageController@show')->where('page', '[a-zA-Z0-9_\-]+');
});