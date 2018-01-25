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

/*'middleware' => ['jwt.api.auth']*/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers', 'middleware'=>'web'], function ($api) {
        $api->get('getsessionkey', 'WxController@getSessionKey');
        $api->post('decrypt', 'WxController@decrypt');
        $api->get('clientinit', 'ClientServerController@clientInit');
        $api->post('/client/settarget', 'ClientServerController@setTarget');
    });

    $api->group(['namespace' => 'App\Api\Controllers', 'middleware'=>'jwt.auth'],function ($api){
       $api->get('lessons','LessonsController@index');
       $api->get('lessons/{id}','LessonsController@show');
    });
});
