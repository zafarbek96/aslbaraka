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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/export_products', 'ProductController@export_products');
    //Route::get('/buy_export/{id}','ExportController@buy_export')->name('buy.export');
    Route::get('/export/{id}','ExportController@export')->name('export');
});

Route::get('/clear-cache', function() {
        $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $exitCode = \Illuminate\Support\Facades\Artisan::call('config:cache');
        $exitCode = \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Session::flush();
        return $exitCode;
    });
