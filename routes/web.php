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

// 网站主页
Route::get('/', 'HomeController@index')->name('index');

// Auth::routes();
// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
// Email 认证相关路由
// ...

// 个人中心
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
Route::get('users/{user}/edit_avatar', 'UsersController@edit_avatar')->name('users.edit_avatar');         // 修改头像
Route::patch('users/{user}/update_avatar', 'UsersController@update_avatar')->name('users.update_avatar'); // 修改头像
Route::get('users/{user}/edit_password', 'UsersController@edit_password')->name('users.edit_password');          // 修改密码
Route::patch('users/{user}/update_password', 'UsersController@update_password')->name('users.update_password');  // 修改密码

// 消息通知
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

// 搜索
Route::get('search', 'SearchController@index')->name('search.index');

Route::get('contact', 'ContactController@index')->name('contact.index');

// 七牛图片库管理
Route::get('qinius', 'QiniusController@index')->name('qinius.index');
Route::get('qinius/images', 'QiniusController@images')->name('qinius.images');
Route::get('qinius/cdns', 'QiniusController@cdns')->name('qinius.cdns');
Route::get('qinius/urls', 'QiniusController@urls')->name('qinius.urls');

// 改版后博客文章 301
Route::get('articles/{article}', function (\Illuminate\Http\Request $request){
    return redirect()->route('blog.articles.show', $request->article);
});

// 回复
Route::resource('replies', 'RepliesController', ['only' => ['store', 'update', 'edit', 'destroy']]);

/**
 * 博客
 */
Route::group(['prefix'=> 'blog'], function (){
    Route::get('/', function (){
        return redirect()->to('/');
    });

    // 标签
    Route::get('tags/{tag}', 'BlogTagsController@show')->name('blog.tags.show');

    // 分类
    Route::resource('categories', 'BlogCategoriesController', [
        'names' => [
            'index' => 'blog.categories.index',
            'show' => 'blog.categories.show',
            'create' => 'blog.categories.create',
            'store' => 'blog.categories.store',
            'edit' => 'blog.categories.edit',
            'update' => 'blog.categories.update',
            'destroy' => 'blog.categories.destroy',
        ],
        'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']
    ]);

    // 文章
    Route::resource('articles', 'BlogArticlesController', [
        'names'=> [
            'index' => 'blog.articles.index',
            'show' => 'blog.articles.show',
            'create' => 'blog.articles.create',
            'store' => 'blog.articles.store',
            'edit' => 'blog.articles.edit',
            'update' => 'blog.articles.update',
            'destroy' => 'blog.articles.destroy',
        ],
        'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']
    ]);
});

/**
 * 教程 书籍
 */
Route::group(['prefix'=> 'course'], function(){
    // 订单
    Route::resource('orders', 'CourseBookOrdersController', [
        'names'=> [
            'index' => 'course.orders.index',
            'show' => 'course.orders.show',
            'edit' => 'course.orders.edit',
            'update' => 'course.orders.update',
            'destroy' => 'course.orders.destroy',
        ],
        'only' => ['index','show', 'edit', 'update', 'destroy']
    ]);

    // 教程
    Route::resource('books', 'CourseBooksController', [
        'names'=> [
            'index' => 'course.books.index',
            'show' => 'course.books.show',
            'create' => 'course.books.create',
            'store' => 'course.books.store',
            'edit' => 'course.books.edit',
            'update' => 'course.books.update',
            'destroy' => 'course.books.destroy',
        ]
    ]);
    // 目录
    Route::resource('{book}/sections', 'CourseSectionsController', [
        'names'=> [
            'index' => 'course.sections.index',
            'create' => 'course.sections.create',
            'store' => 'course.sections.store',
            'edit' => 'course.sections.edit',
            'update' => 'course.sections.update',
            'destroy' => 'course.sections.destroy',
        ],
        'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']
    ]);
    // 文章
    Route::resource('{book}/articles', 'CourseArticlesController', [
        'names'=> [
            'show' => 'course.articles.show',
            'create' => 'course.articles.create',
            'store' => 'course.articles.store',
            'edit' => 'course.articles.edit',
            'update' => 'course.articles.update',
            'destroy' => 'course.articles.destroy',
        ],
        'only' => ['show', 'create', 'store', 'edit', 'update', 'destroy']
    ]);
    // 购买
    Route::resource('{book}/purchases', 'CoursePurchasesController', [
        'names'=> [
            'index' => 'course.purchases.index',
        ],
        'only' => ['index']
    ]);
});
