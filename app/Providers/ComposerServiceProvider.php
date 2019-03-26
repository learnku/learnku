<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * 在容器中注册绑定
     * https://learnku.com/docs/laravel/5.5/views/1299#sharing-data-with-all-views
     *
     * @return void
     */
    public function boot()
    {
        // 使用基于类的 composer...
        // 将视图构造器添加到多个视图
        View::composer(
            ['layouts.app'],
            'App\Http\ViewComposers\WebComposer'
        );

        // 博客公用数据
        View::composer(
            ['pages.blog_articles._sidebar'],
            'App\Http\ViewComposers\BlogComposer'
        );

        // 使用基于闭包的 composers...
        // View::composer('*', function ($view) {
        //
        // });
    }

    /**
     * 注册服务器提供者
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
