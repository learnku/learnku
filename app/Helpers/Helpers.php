<?php

if (!function_exists('route_class')) {
    /**
     * 根据当前路由 生成 class
     * @return mixed
     */
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

if (!function_exists('assert_images')) {
    /**
     * 七牛 images 镜像空间
     * @param $path
     * @param null $secure
     * @return mixed
     */
    function assert_images($path, $secure = null)
    {
        return config('app.images_url') . $path;
    }
}

if (!function_exists('assert_cdns')) {
    /**
     * 七牛 cdns 镜像空间
     * @param $path
     * @param null $secure
     * @return mixed
     */
    function assert_cdns($path, $secure = null)
    {
        return config('app.cdns_url') . $path;
    }
}
