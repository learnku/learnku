<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use Illuminate\Http\Request;
# use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthorizationsController extends Controller
{
    // api 登录
    public function store(AuthorizationRequest $request)
    {
        $credentials['email'] = $request->email;
        $credentials['password'] = $request->password;

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->errorUnauthorized('用户名或密码错误');
        }

        return $this->respondWithToken($token);
    }

    // 刷新 token
    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }

    // 删除 token
    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->noContent();
    }

    // 响应 token
    protected function respondWithToken($token)
    {
        return response([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ], 201);
    }
}
