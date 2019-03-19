<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Traits\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use ApiHelper;

    /**
     * 通过 jwt token 获取当前登录用户
     * @return mixed
     */
    public function user(){
        return Auth::guard('api')->user();
    }
}
