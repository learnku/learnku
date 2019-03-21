<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'gender',
        'github_name',
        'real_name',
        'city',
        'company',
        'jobtitle',
        'personal_website',
        'wechat_qrcode',
        'payment_qrcode',
        'introduction',
        'signature',
        'avatar',
        'image_id'
    ];

    // 用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 头像
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
