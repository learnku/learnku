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
], function ($router){
    // 登录
    $router->post('authorizations', 'AuthorizationsController@login')
        ->name('api.authorizations.login');
});


// 需要 token 验证的接口
Route::group([
    'namespace'=> 'Api',
    'middleware'=> 'auth:api',
], function ($router){
    // 刷新token
    $router->put('authorizations/refresh', 'AuthorizationsController@refresh')
        ->name('api.authorizations.refresh');
    // 删除token
    $router->delete('authorizations/logout', 'AuthorizationsController@logout')
        ->name('api.authorizations.logout');
    // 获取当前登录用户信息
    $router->get('me', 'AuthorizationsController@me')->name('api.me.show');

    // 图片资源
    $router->post('images', 'ImagesController@store')->name('api.images.store');
});


