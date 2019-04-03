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
                ->select('users.*', 'A.path as avatar_path', 'B.id as user_infos_id')
                ->addSelect('B.gender', 'B.github_name', 'B.real_name', 'B.city', 'B.company', 'B.jobtitle', 'B.personal_website', 'B.wechat_qrcode', 'B.payment_qrcode', 'B.introduction', 'B.signature', 'B.avatar', 'B.image_id', 'B.user_id')
                ->where('users.id', '=', $authId)
                ->leftJoin('images as A', function ($join){
                    $join->on('A.user_id', '=', 'users.id')
                        ->where('A.image_type', '=', 'avatar');
                })
                ->leftJoin('user_infos as B', 'B.user_id', '=', 'users.id')
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
