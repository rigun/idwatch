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

Route::get('/', function () {return view('app');});
Route::get('/dashboard', function () {return view('admin');});
Route::get('/dashboard/brand', function () {return view('admin');});
Route::get('/dashboard/add', function () {return view('admin');});
Route::get('/dashboard/product', function () {return view('admin');});
Route::get('/dashboard/report', function () {return view('admin');});
Route::get('/dashboard/confirm', function () {return view('admin');});
Route::get('/dashboard/trash', function () {return view('admin');});
Route::get('/dashboard/discount', function () {return view('admin');});
Route::get('/dashboard/changepassword', function () {return view('admin');});
Route::get('/dashboard/detail/{id}', function () {return view('admin');});
Route::get('/admin/login', function () {return view('admin');});
Route::get('/login', function () {return view('app');});
Route::get('/contact', function () {return view('app');});
Route::get('/shop', function () {return view('app');});
Route::get('/shop/{type}/{category}', function () {return view('app');});
Route::get('/cart', function () {return view('app');});
Route::get('/detail/{slug}', function () {return view('app');});
Route::get('/list/{type}/{category}', function () {return view('app');});
Route::get('/search/{search}', function () {return view('app');});
Route::get('/checkout/{token}', function () {return view('app');});
Route::get('/confirm', function () {return view('app');});
Route::get('/history', function () {return view('app');});
Route::get('/checkoutcart', function () {return view('app');});
Route::get('/tentangkami', function () {return view('app');});
Route::get('/caraorder', function () {return view('app');});
Route::get('/logout', function () {return view('app');});
Route::get('/forgetpassword', function () {return view('app');});
Route::get('/verifforgetpassword/{status}', function () {return view('app');});
Route::get('/view/export', function () {return view('exports.transaction');});
