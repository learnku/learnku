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

// 游客可以访问的接口
Route::group([
    'namespace'=> 'Api',
], function (){
    // 登录
    Route::post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');
    // 刷新token
    Route::put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    // 删除token
    Route::delete('authorizations/current', 'AuthorizationsController@destroy')
        ->name('api.authorizations.destroy');
});

// 需要 token 验证的接口
Route::group([
    'namespace'=> 'Api',
    'middleware'=> 'auth:api',
], function (){
    // 图片资源
    // Route::post('images', 'ImagesController@store')->name('api.images.store');
    Route::post('images', 'ImagesController@store')->name('api.images.store');
});


