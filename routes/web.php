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

Route::get('/', function () {
    return view('home');
});



Route::post('/pay', 'PublicSslCommerzPaymentController@index');
Route::post('/success', 'PublicSslCommerzPaymentController@success');
Route::post('/fail', 'PublicSslCommerzPaymentController@fail');
Route::post('/cancel', 'PublicSslCommerzPaymentController@cancel');
Route::post('/ipn', 'PublicSslCommerzPaymentController@ipn');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
// test 1


// test 2

// test 3