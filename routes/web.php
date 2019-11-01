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
    $this->user = \Auth::user();
    
    if(@$this->user->id){
        return redirect('/dashboard');
    }else{
        return view('auth.login');      
    }
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::prefix('/admin')->group( function (){
    Route::get('/user', 'UserController@index')->name('user');
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

Route::prefix('/settings')->group( function (){
	Route::get('/', 'SettingsController@index')->name('settings');
	Route::post('/update', 'SettingsController@updateConfig');
});

Route::prefix('/referrals')->group( function (){
	Route::get('/', 'ReferralController@index')->name('referrals');
	Route::post('/list', 'ReferralController@get_list');
});

Route::prefix('/store')->group( function (){
    Route::get('/', 'StoreController@index')->name('store');
    Route::post('/list', 'StoreController@get_list');
    Route::post('/changeStatus', 'StoreController@changeStoreStatus');
    Route::get('/detail/{id}', 'StoreController@get_detail');
    Route::post('/campaign', 'StoreController@campaign_list');
    Route::post('/changeCampaignStatus', 'StoreController@changeCampaignStatus');
    Route::post('/getForm', 'StoreController@getFormHtml');
    Route::post('/update', 'StoreController@updateStore');
    Route::post('/new', 'StoreController@createNew');
    Route::post('/getCampaignForm', 'StoreController@getCampaignFormHtml');
    Route::post('/updateCampaign', 'StoreController@updateCampaign');
    Route::post('/newCampaign', 'StoreController@createNewCampaign');
    // Route::post('/update', 'SettingsController@updateConfig');
});