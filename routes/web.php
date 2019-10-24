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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->group( function (){
    Route::get('/user', 'UserController@index')->name('home');
    Route::post('/list', 'UserController@get_list');
});


Route::prefix('/customer')->group( function (){
    Route::get('/', 'CustomerController@index')->name('customer');
    Route::post('/list', 'CustomerController@get_list');
    Route::get('/detail/{id}', 'CustomerController@get_detail');
    Route::post('/changeUserStatus', 'CustomerController@changeUserStatus');
});

Route::post('/ordersList', 'OrderController@get_list');
Route::post('/wallet_history_list', 'WalletController@get_list');
Route::get('/order', 'OrderController@index')->name('order');
Route::get('/wallet', 'WalletController@index')->name('wallet');
Route::get('/settings', 'SettingsController@index')->name('settings');