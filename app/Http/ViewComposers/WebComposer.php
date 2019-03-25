<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class WebComposer
{
    // 当前登录用户
    protected $currentUser;

    /**
     * 创建一个新的 profile composer
     *
     * @return void
     */
    public function __construct(User $user)
    {
        // 当前登录用户
        $this->currentUser = null;

        if (Auth::check()) {
            // 当前登录用户 id
            $authId = Auth::user()->id;

            // 获取当前登录用户 信息
            $this->currentUser = $user
                ->select('users.*', 'images.path as avatar_path', 'user_infos.*')
                ->where('users.id', '=', $authId)
                ->leftJoin('images', function ($join){
                    $join->on('images.user_id', '=', 'users.id')
                        ->where('images.image_type', '=', 'avatar');
                })
                ->leftJoin('user_infos', 'user_infos.user_id', '=', 'users.id')
                ->first();
        }
    }

    /**
     * 将数据绑定到视图。
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['common'=> [
        	'auth'=> $this->currentUser,
        ]]);
    }
}
