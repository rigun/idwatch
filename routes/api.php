<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('renewPassword', 'UserController@updatePassword');
    Route::get('refresh', 'AuthController@refresh');

    Route::get('/item/unique', 'ItemController@apiCheckUnique');
    Route::post('/item', 'ItemController@store');
    Route::post('/item/{id}', 'ItemController@update');
    Route::delete('/item/{id}', 'ItemController@destroy');
    Route::delete('/item/permanent/{id}', 'ItemController@permanentDestroy');
    Route::get('/item/restore/{id}', 'ItemController@restore');
    Route::get('/item/trash', 'ItemController@trash');

    Route::delete('/picture/{id}', 'PictureController@destroy');
    Route::get('/picture/{itemId}', 'PictureController@show');
    Route::post('/picture', 'PictureController@store');

    Route::post('/cart','CartController@store');
    Route::patch('/cart/{id}','CartController@update');
    Route::delete('/cart/{id}','CartController@destroy');
    Route::get('/cart','CartController@index');
    Route::get('/count','CartController@countCart');
    Route::get('/mycart','CartController@showByUser');
    Route::post('/updateQuantity/{id}','CartController@updateQuantity');
    Route::get('/mycheckoutcart','TransactionController@checkoutcartByUser');

    Route::get('/myhistory','TransactionController@myhistory');
    Route::post('/mytransaction','TransactionController@store');
    Route::post('/verifikasi/{id}','TransactionController@verifikasi');
    Route::get('/report','TransactionController@index');
    Route::get('/confirm','TransactionController@confirm');
    Route::get('/mytransaction/{token}','TransactionController@show');
    Route::post('/order','TransactionController@order');
    Route::post('/evidence/{id}','TransactionController@evidence');
    Route::delete('/evidence/{id}','TransactionController@deleteEvidence');
    Route::post('/cupon','DiscountController@store');
    Route::delete('/cupon/{id}','DiscountController@destroy');
    Route::patch('/cupon/{id}','DiscountController@update');
    Route::get('/cupon/{cupon}','DiscountController@show');
    Route::get('/cupon','DiscountController@index');

    Route::post('/comment','CommentController@store');
    Route::delete('/comment/{id}','CommentController@destroy');

    Route::get('/brand','BrandController@index');
    Route::post('/brand','BrandController@store');
    Route::patch('/brand/{id}','BrandController@update');
    Route::delete('/brand/{id}','BrandController@destroy');

});
Route::get('/report/download','TransactionController@export');

Route::get('/dashboard/graph','TransactionController@graph');

Route::get('/rajaongkir/provinsi','RajaOngkirController@provinsi');
Route::get('/rajaongkir/kota/{provinsi_id}','RajaOngkirController@kotaByProvinsi');
Route::get('/rajaongkir/{id_kota}/{weight}','RajaOngkirController@cost');

Route::get('/comment/{item_id}','CommentController@show');
Route::post('/mail/contactus','MailController@send');
Route::post('forgetpassword', 'MailController@forgetpassword');

Route::get('/itemAll', 'ItemController@showAll');

Route::get('/unconfirmCount','TransactionController@count');
Route::get('/item', 'ItemController@index');
Route::get('/search/{search}', 'ItemController@search');
Route::get('/item/detail/{slug}', 'ItemController@showBySlug');
Route::get('/item/{id}', 'ItemController@show');
Route::get('/item/{type}/{category}', 'ItemController@showByCategory');

Route::post('register', 'AuthController@register');
Route::get('/user/email/{email}', 'UserController@UniqueEmail');
Route::post('/updatepassword/forget/{status}', 'UserController@updatepasswordForget');
Route::get('/category','CategoryController@index');


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');

});
