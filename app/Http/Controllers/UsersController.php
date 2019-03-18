<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }

    // 修改资料
    public function edit(User $user)
    {
        // dd($user->info()->toSql());
        return view('pages.users.edit', compact('user'));
    }

    // 更新资料
    public function update(UserRequest $reques, User $user)
    {
        dd($reques->toArray());
    }

    // 修改头像
    public function edit_avatar(User $user)
    {
        return view('pages.users.edit_avatar', compact('user'));
    }

    // 更新头像
    public function update_avatar()
    {
    }

    // 修改密码
    public function edit_password(User $user)
    {
        return view('pages.users.edit_password', compact('user'));
    }

    // 更新密码
    public function update_password()
    {
    }
}
