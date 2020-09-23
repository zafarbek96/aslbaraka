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

Route::group(['prefix' => 'v1',], function () {
    //authorization
	Route::post('login', ['uses'=>'UserController@login', 'as'=>'api.login']);

});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'v1' ], function () {

Route::get('/users','UserController@show');
Route::get('/userall', 'UserController@showapi');
Route::get('/products','ProductController@show');
Route::get('/action','ProductController@showAction');
Route::get('/get-all','ProductController@showapi' );
Route::get('/pro', 'ProductController@showapi');
Route::get('/new', 'ProductController@new_old');
Route::post('/orders','OrderController@create');
Route::get('/all','OrderController@showapi');
Route::get('/type','TypeController@show');
Route::get('/getAll','TypeController@getAll');
Route::get('/tur','TurlarController@getAll');
Route::post('/all_create','OrderController@all_creat');
Route::get('search','ProductController@all_search');
Route::post('chat','UserController@chat_create');
Route::get('/many','OrderController@many');
Route::get('/aksiya', 'PresentController@showapi');
Route::get('/history', 'OrderController@history');
Route::get('/toptovar', 'OrderController@toptovar');
Route::get('/meneger', 'OrderController@history_meneger');
Route::get('produc', function () {
    return App\Product::paginate();
});


});









