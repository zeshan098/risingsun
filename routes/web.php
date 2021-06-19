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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear'); 
    return "Cache is cleared";
});
//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});
// Route::get('/donation', 'DonationsController@donation')->name('donation');
// Route::Post('/donation_submit', 'DonationsController@donation_submit')->name('donation_submit');
 
// Route::get('send_alert', 'DonationsController@send_alert')->name('send_alert');
// Login Routes...
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Registration Routes...
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);
// Route::post('register', function(){
//     return "Hi";
// });

// Password Reset Routes...
Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);



Route::group(['prefix' => 'admin',  'middleware' => 'auth',  'middleware' => 'role:admin'], function() {
    //Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    
    Route::get('/', function () {
        return redirect()->route('home');
    });
    Route::get('users', 'UserController@users')->name('list_users');
    Route::get('add_user', 'UserController@add_user_view')->name('add_user');
    Route::get('delete_user/{id}', 'UserController@delete_user')->name('delete_user');
    Route::post('add_user_post', 'UserController@add_user_post')->name('add_user_post');
    Route::get('pending_user', 'UserController@pending_user')->name('pending_user');
    Route::get('update_pending_user/{id}', 'UserController@update_pending_user')->name('update_pending_user');
    
    //Update Password 
    Route::get('update_password/{id}', 'UserController@update_password')->name('update_password');
    Route::post('password/{id}', 'UserController@password')->name('password'); 


    Route::get('show_donation', 'DonationsController@show_donation')->name('show_donation');
    Route::get('donation', 'DonationsController@donation')->name('donation');
    Route::Post('donation_submit', 'DonationsController@donation_submit')->name('donation_submit');
    Route::get('view_donation/{id}', 'DonationsController@view_donation')->name('view_donation');
    Route::get('generate-pdf/{id}','DonationsController@generatePDF')->name('generate-pdf');
    Route::get('delete_donation/{id}', 'DonationsController@delete_donation')->name('delete_donation');
    Route::get('assign_list', 'DonationsController@assign_list')->name('assign_list');
    Route::get('edit_donation/{id}', 'DonationsController@edit_donation')->name('edit_donation');
    Route::Post('update_donation/{id}', 'DonationsController@update_donation')->name('update_donation');
    //SMS
    Route::get('add_sms', 'DonationsController@add_sms')->name('add_sms');
    Route::Post('sms_submit', 'DonationsController@sms_submit')->name('sms_submit');
    Route::get('sms_list', 'DonationsController@sms_list')->name('sms_list');
    Route::get('delete_sms/{id}', 'DonationsController@delete_sms')->name('delete_sms');
    Route::get('update_sms/{id}', 'DonationsController@update_sms')->name('update_sms');
    Route::post('sms/{id}', 'DonationsController@sms')->name('sms'); 
    
    //Customer
    Route::post('customer_add', 'DonationsController@customer_add')->name('customer_add');
    Route::post('search_customer', 'DonationsController@search_customer')->name('search_customer');
    Route::get('customer_list', 'DonationsController@customer_list')->name('customer_list');
    Route::get('customer_detail/{id}', 'DonationsController@customer_detail')->name('customer_detail');
    Route::post('update_detail/{id}', 'DonationsController@update_detail')->name('update_detail');
    Route::get('delete_donor/{id}', 'DonationsController@delete_donor')->name('delete_donor');
    
    //donar add
    Route::get('add_donar', 'DonationsController@add_donar')->name('add_donar');
    Route::post('create_donar', 'DonationsController@create_donar')->name('create_donar');
    
    //Incentive
    Route::get('add_incentive', 'IncentiveController@add_incentive')->name('add_incentive');
    Route::post('create_incentive', 'IncentiveController@create_incentive')->name('create_incentive');
    Route::get('incentive_list', 'IncentiveController@incentive_list')->name('incentive_list');
    Route::get('delete_incentive/{id}', 'IncentiveController@delete_incentive')->name('delete_incentive');
    Route::get('update_incentive/{id}', 'IncentiveController@update_incentive')->name('update_incentive');
    Route::post('complete_incentive/{id}', 'IncentiveController@complete_incentive')->name('complete_incentive'); 
    
    //Report
    Route::get('incentive_report', 'IncentiveController@incentive_report')->name('incentive_report');
    Route::post('incentive_reporting', 'IncentiveController@incentive_reporting')->name('incentive_reporting');
    Route::get('collection_report', 'IncentiveController@collection_report')->name('collection_report');
    Route::post('collection_reporting', 'IncentiveController@collection_reporting')->name('collection_reporting');
    Route::get('resource_report', 'IncentiveController@resource_report')->name('resource_report');
    Route::post('resource_reporting', 'IncentiveController@resource_reporting')->name('resource_reporting');
 
});
Route::group(['prefix' => 'executive',  'middleware' => 'auth',  'middleware' => 'role:admin,executive', 'as' => 'executive.'], function(){
    Route::get('show_donation', 'DonationsController@show_donation')->name('show_donation');
    Route::get('donation', 'DonationsController@donation')->name('donation');
    Route::Post('donation_submit', 'DonationsController@donation_submit')->name('donation_submit');
    Route::get('view_donation/{id}', 'DonationsController@view_donation')->name('view_donation');
    Route::get('generate-pdf/{id}','DonationsController@generatePDF')->name('generate-pdf');
    Route::get('delete_donation/{id}', 'DonationsController@delete_donation')->name('delete_donation');
    Route::get('assign_list', 'DonationsController@assign_list')->name('assign_list');
    Route::get('edit_donation/{id}', 'DonationsController@edit_donation')->name('edit_donation');
    Route::Post('update_donation/{id}', 'DonationsController@update_donation')->name('update_donation');
    //SMS
    Route::get('add_sms', 'DonationsController@add_sms')->name('add_sms');
    Route::Post('sms_submit', 'DonationsController@sms_submit')->name('sms_submit');
    Route::get('sms_list', 'DonationsController@sms_list')->name('sms_list');
    Route::get('delete_sms/{id}', 'DonationsController@delete_sms')->name('delete_sms');
    Route::get('update_sms/{id}', 'DonationsController@update_sms')->name('update_sms');
    Route::post('sms/{id}', 'DonationsController@sms')->name('sms'); 
    
    //Update Password 
    Route::get('update_password/{id}', 'UserController@update_password')->name('update_password');
    Route::post('password/{id}', 'UserController@password')->name('password'); 
    
    //Customer
    Route::post('customer_add', 'DonationsController@customer_add')->name('customer_add');
    Route::post('search_customer', 'DonationsController@search_customer')->name('search_customer');
    
    
    
});   

Route::group(['prefix' => 'finance',  'middleware' => 'auth',  'middleware' => 'role:admin,finance', 'as' => 'finance.'], function(){
   
   //Report
   Route::get('incentive_report', 'IncentiveController@incentive_report')->name('incentive_report');
   Route::post('incentive_reporting', 'IncentiveController@incentive_reporting')->name('incentive_reporting');
   Route::get('collection_report', 'IncentiveController@collection_report')->name('collection_report');
   Route::post('collection_reporting', 'IncentiveController@collection_reporting')->name('collection_reporting');
   Route::get('resource_report', 'IncentiveController@resource_report')->name('resource_report');
   Route::post('resource_reporting', 'IncentiveController@resource_reporting')->name('resource_reporting');
});   