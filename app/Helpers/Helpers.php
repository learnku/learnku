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
