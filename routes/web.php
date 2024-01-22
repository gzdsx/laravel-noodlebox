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

Route::get('admin', 'Admin\IndexController@index');
Route::get('vue-admin', 'Admin\VueController@index');

//redirect
Route::redirect('/fort-st-john', '/');
Route::redirect('/dawsoncreek', '/');
Route::redirect('/residential', '/rental/listings');
Route::redirect('/agency/sterling-management-services-ltd', '/join-us');
Route::redirect('/about-sterling', '/about-us');
Route::redirect('/formsresources', '/forms-resources');
Route::redirect('/about', '/about-us');

Route::namespace('Web')->group(function () {
    Route::get('/', 'IndexController@index');
    Route::get('rental/listings', 'RentalController@listings');
    Route::post('rental/listings/query', 'RentalController@query');
    Route::get('rental/listings/{id}', 'RentalController@showListing');
    Route::get('rental/listings/{id}/messagebox', 'RentalController@showListingBox');
    Route::get('rental/units', 'RentalController@units');
    Route::get('association/units', 'AssociationController@units');
    Route::get('forms-resources', 'FormController@index');
    Route::get('forms/{name}', 'FormController@show2')->where('name', '[a-zA-Z0-9_\-]+');
    Route::get('forms/{form}/units/{unit}/upload', 'FormController@upload')->where('form', '[a-zA-Z0-9_\-]+');
    Route::get('forms/{form}/units/{unit}/submit', 'FormController@submit')->where('form', '[a-zA-Z0-9_\-]+');
    Route::post('files/upload', 'FileController@upload');
    Route::post('files/submit', 'FileController@submit');

    Route::get('services', 'ServiceController@index');
    Route::get('insights-research', 'InsightController@index');

    Route::get('post/{cate?}', 'PostController@index')->where('cate', '[0-9]+');
    Route::get('post/{name}', 'PostController@show');
    Route::get('insights-research/{name}', 'PostController@show');
    Route::get('services/{name}', 'PostController@show');
    Route::get('post/{id}.html', 'PostController@show')->where('id', '[0-9]+');

    Route::get('properties', 'PropertyController@index');
    Route::get('properties/json', 'PropertyController@json');
    Route::get('property/{id}', 'PropertyController@show');

    Route::post('contacts/rfp', 'ContactController@rfp');
    Route::post('contacts/contact', 'ContactController@contact');
    Route::post('contacts/joinus', 'ContactController@joinus');
    Route::post('contacts/listing', 'ContactController@listing');

    Route::post('agents/{id}/message', 'AgentController@message');

    Route::get('search', 'SearchController@index');
    Route::get('{page}', 'PageController@show')->where('page', '[a-zA-Z0-9_\-]+');
});