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




Route::middleware(['web'])->group(function () {
    Route::get('/', 'LoginController@index');
    Route::get('/signin', 'LoginController@signin');
    Route::get('/signout', 'LoginController@signout');

    Route::post('/signout/distname', 'LoginController@distBusinessName');
    Route::post('/signout/register', 'LoginController@signoutUser');

    Route::post('/signin', 'LoginController@doSignin');

    Route::post('/good/add', 'GoodsController@addGood');
    Route::get('/good/get/{code}', 'GoodsController@getGood');
    Route::get('/good/del/{code}', 'GoodsController@delGood');



    Route::middleware(['checkLogin'])->group(function () {
        Route::get('/index', 'IndexController@index');
        Route::get('/info', 'IndexController@info');
        Route::get('/check', 'CheckController@index');
        Route::get('/goods', 'GoodsController@index');
        Route::get('/logout', 'LoginController@logout');
    });


});
