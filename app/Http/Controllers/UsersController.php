<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $user_id = Auth::id();
        $_user = [
            'name' => $reques->name,
            'email' => $reques->email,
        ];
        $_info = [
            "gender" => $reques->gender=='male' ? '1' : '0',
            "github_name" => $reques->github_name,
            "real_name" => $reques->real_name,
            "city" => $reques->city,
            "company" => $reques->company,
            "jobtitle" => $reques->jobtitle,
            "personal_website" => $reques->personal_website,
            "introduction" => $reques->introduction,
            "signature" => $reques->signature,
        ];
        Auth::user()->update($_user);
        Auth::user()->info->update($_info);

        return redirect()->route('users.edit', $user->id)->with('success', '个人资料更新成功！');
    }

    // 修改头像
    public function edit_avatar(User $user)
    {
        return view('pages.users.edit_avatar', compact('user'));
    }

    // 更新头像
    public function update_avatar(Request $request, User $user)
    {
        $_info = [
            'image_id'=> $request->image_id
        ];
        Auth::user()->info->update($_info);
        return redirect()->route('users.edit_avatar', $user->id)->with('success', '个人头像更新成功 ！');
    }

    // 修改密码
    public function edit_password(User $user)
    {
        return view('pages.users.edit_password', compact('user'));
    }

    // 更新密码
    public function update_password(Request $request, User $user)
    {
        $this->validate($request,[
            // 不为空,两次密码是否相同
            'password'=>['required', 'min:6', 'confirmed'
            ],
        ],[
            'password.required'=>"密码不能为空",
            'password.confirmed'=>"密码与确认密码不匹配",
        ]);

        Auth::user()->update([
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('users.edit_password', $user->id)->with('success', '个人密码更新成功 !');
    }
}
