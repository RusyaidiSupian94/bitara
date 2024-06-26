<?php

use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\Profile;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Customer;
use App\Http\Controllers\dashboard\Orders;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\settings\Staff;
use Illuminate\Support\Facades\Route;

// Main Page Route
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/dashboard', [Analytics::class, 'index'])->name('dashboard-analytics');
Route::get('/dashboard-data', [Analytics::class, 'dashboard_data'])->name('data-dashboard');
Route::get('/dashboard-data-trend', [Analytics::class, 'dashboard_data_trend'])->name('data-trend-dashboard');
Route::get('/product-dashboard', [Analytics::class, 'product_dashboard'])->name('dashboard-product');
Route::get('/reporting-dashboard', [Analytics::class, 'reporting_dashboard'])->name('dashboard-reporting');
Route::get('/product-add', [Analytics::class, 'product_add'])->name('add-product');
Route::get('/product-list', [Analytics::class, 'product_list'])->name('list-product');
Route::post('/product-store', [Analytics::class, 'product_store'])->name('store-product');
Route::post('/product-delete', [Analytics::class, 'product_delete'])->name('delete-product');
Route::get('/product-edit/{id}', [Analytics::class, 'product_edit'])->name('edit-product');
Route::post('/product-store-edited/{id}', [Analytics::class, 'product_store_edited'])->name('store-edited-product');

Route::get('/order-dashboard', [Orders::class, 'order_dashboard'])->name('dashboard-order');
Route::get('/order-datatable', [Orders::class, 'order_datatable'])->name('datatable-order');
Route::get('/order-process/{id}', [Orders::class, 'order_process'])->name('process-order');
Route::get('/order-prepare/{id}', [Orders::class, 'order_prepare'])->name('prepare-order');
Route::get('/order-cancel/{id}', [Orders::class, 'order_cancel'])->name('cancel-order');
Route::get('/order-ready/{id}', [Orders::class, 'order_ready'])->name('ready-order');
Route::get('/order-deliver/{id}', [Orders::class, 'order_deliver'])->name('deliver-order');
Route::get('/order-complete/{id}/{page}', [Orders::class, 'order_complete'])->name('complete-order');
Route::get('/order-complete-detail', [Orders::class, 'order_complete_detail'])->name('complete-order-detail');
Route::get('/order-add', [Orders::class, 'order_add'])->name('add-order');
Route::get('/order-edit/{id}', [Orders::class, 'order_edit'])->name('edit-order');
Route::post('/order-store', [Orders::class, 'order_store'])->name('store-order');
Route::get('/manual-order-dashboard', [Orders::class, 'manual_order_dashboard'])->name('dashboard-manual-order');
Route::post('/order-edited-store/{id}', [Orders::class, 'order_edited_store'])->name('store-edited-order');
Route::post('/remove-edited-order-item', [Orders::class, 'remove_edited_order_item'])->name('remove-edited-order-item');
Route::post('/order-delete', [Orders::class, 'order_delete'])->name('delete-order');

Route::get('/customer-dashboard', [Customer::class, 'customer_dashboard'])->name('dashboard-customer');
Route::post('/cart-datatable', [Customer::class, 'cart_datatable'])->name('cart-datatable');
Route::post('/cart-remove', [Customer::class, 'cart_remove'])->name('cart-remove');
Route::post('/cart-qty', [Customer::class, 'cart_qty'])->name('cart-qty');
Route::get('/get_payment_poscode_details', [Customer::class, 'get_payment_poscode_details'])->name('get-payment-poscode-details');
// Route::get('/checkout', [Customer::class, 'checkout'])->name('checkout');

//payment
Route::get('/payment-add', [Customer::class, 'add_payment'])->name('add-payment');
Route::post('/payment-order/{id}', [Customer::class, 'order_payment'])->name('order-payment');

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::post('/auth/check-login', [LoginBasic::class, 'authenticate'])->name('auth-check-login');
Route::post('/auth/register-customer', [RegisterBasic::class, 'registerCustomer'])->name('auth-register-customer');
Route::get('/get_poscode_details', [RegisterBasic::class, 'get_poscode_details'])->name('get-poscode-details');
Route::get('/logout', [LoginBasic::class, 'logout'])->name('logout');

Route::get('/update-profile/{id}', [Profile::class, 'index'])->name('update-profile');
Route::get('/get_profile_poscode_details', [Profile::class, 'get_profile_poscode_details'])->name('get-profile-poscode-details');
Route::post('/save-updated-profile', [Profile::class, 'save'])->name('save-updated-profile');

Route::get('/setting/dashboard-staff', [Staff::class, 'index'])->name('dashboard-staff');
Route::get('/setting/add-staff', [Staff::class, 'add_staff'])->name('add-staff');
Route::post('/setting/delete-staff', [Staff::class, 'delete_staff'])->name('delete-staff');
Route::post('/setting/save-staff', [Staff::class, 'save_staff'])->name('save-staff');
Route::get('/setting/edit-staff/{id}', [Staff::class, 'edit_staff'])->name('edit-staff');
Route::post('/setting/save-edited-staff/{id}', [Staff::class, 'save_edited_staff'])->name('save-edited-staff');
