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
    // return view('welcome');
    return redirect()->route('login');
});
 
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
        return redirect()->route('login');
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


    //Dashborad
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    // Route::get('ss', 'DashboardController@ss')->name('ss');
    
    //Product_Catagory
    Route::get('category', 'InventoryController@category')->name('category');
    Route::Post('add_category', 'InventoryController@add_category')->name('add_category');
    Route::get('update_category/{id}', 'InventoryController@update_category')->name('update_category');
    Route::post('edit_category/{id}', 'InventoryController@edit_category')->name('edit_category');
    Route::get('delete_category/{id}', 'InventoryController@delete_category')->name('delete_category');

    //Brand 
    Route::Post('add_brand', 'InventoryController@add_brand')->name('add_brand');
    //Product
    Route::get('product', 'InventoryController@product')->name('product');
    Route::post('add_product', 'InventoryController@add_product')->name('add_product');
    Route::post('check_code', 'InventoryController@check_code')->name('check_code');
    Route::get('update_product/{id}', 'InventoryController@update_product')->name('update_product');
    Route::post('edit_product/{id}', 'InventoryController@edit_product')->name('edit_product');
    Route::get('delete_product/{id}', 'InventoryController@delete_product')->name('delete_product');
    
    //Add Vender
   Route::get('vendor', 'InventoryController@vendor')->name('vendor');
   Route::post('add_vendor', 'InventoryController@add_vendor')->name('add_vendor');
   Route::get('update_vendor/{id}', 'InventoryController@update_vendor')->name('update_vendor');
   Route::post('edit_vendor/{id}', 'InventoryController@edit_vendor')->name('edit_vendor');
   Route::get('delete_vendor/{id}', 'InventoryController@delete_vendor')->name('delete_vendor');
   
   //Add Product Qty
   Route::get('place_order', 'InventoryController@place_order')->name('place_order');
   Route::post('add_order_qty', 'InventoryController@add_order_qty')->name('add_order_qty'); 


   Route::get('view_place_order', 'InventoryController@view_place_order')->name('view_place_order');
   Route::post('place_order_report', 'InventoryController@place_order_report')->name('place_order_report');
   
   //vendor payment
   Route::get('show', 'VendorPaymentController@show')->name('show');
   Route::get('vendor_pending_payment/{id}', 'VendorPaymentController@vendor_pending_payment')->name('vendor_pending_payment');
   Route::get('edit_vendor_payment/{id}', 'VendorPaymentController@edit_vendor_payment')->name('edit_vendor_payment');
   Route::post('paid_payment/{id}', 'VendorPaymentController@paid_payment')->name('paid_payment');

   //vendor  report
   Route::get('vendor_payment_report', 'VendorPaymentController@vendor_payment_report')->name('vendor_payment_report');
   Route::post('view_vendor_payment_report', 'VendorPaymentController@view_vendor_payment_report')->name('view_vendor_payment_report');
   
   //city
   Route::get('city', 'BillingController@city')->name('city');
   Route::post('add_city', 'BillingController@add_city')->name('add_city');
   Route::get('update_city/{id}', 'BillingController@update_city')->name('update_city');
   Route::post('edit_city/{id}', 'BillingController@edit_city')->name('edit_city');
   Route::get('delete_city/{id}', 'BillingController@delete_city')->name('delete_city');

   //Invoice
   Route::get('invoice', 'BillingController@invoice')->name('invoice');
   Route::post('create_invoice', 'BillingController@create_invoice')->name('create_invoice');
   Route::Post('show_product', 'BillingController@show_product')->name('show_product');
   Route::get('get_invoice', 'BillingController@get_invoice')->name('get_invoice');
   Route::get('get_product_invoice', 'BillingController@get_product_invoice')->name('get_product_invoice');

   //Invoice Listing
   Route::get('invoice_list', 'BillingController@invoice_list')->name('invoice_list');
   Route::get('view_invoice/{id}', 'BillingController@view_invoice')->name('view_invoice');
   Route::get('delete_invoice/{id}', 'BillingController@delete_invoice')->name('delete_invoice');
   //Add Customer
   
   Route::Post('add_customer', 'BillingController@add_customer')->name('add_customer');
   
   // Finance
   Route::get('get-payment-receipt', 'FinanceController@get_payment_receipt')->name('get-payment-receipt');
   Route::post('post-payment-receipt', 'FinanceController@post_payment_receipt')->name('post-payment-receipt');
   Route::get('statement', 'FinanceController@get_statement')->name('statement');
   Route::post('statement', 'FinanceController@get_statement')->name('statement');
   Route::post('return_product', 'FinanceController@return_product')->name('return_product');

   //Add Balance 
   Route::get('get-payment-balance', 'FinanceController@get_payment_balance')->name('get-payment-balance');
   Route::post('post-payment-balance', 'FinanceController@post_payment_balance')->name('post-payment-balance');
});


