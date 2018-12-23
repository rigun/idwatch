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
    
});
Route::get('/item', 'ItemController@index');
Route::get('/item/{id}', 'ItemController@show');

Route::post('register', 'AuthController@register');
Route::get('/user/email/{email}', 'UserController@UniqueEmail');
Route::get('/category','CategoryController@index');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');

});
