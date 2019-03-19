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
        'avatar',
        'introduction',
        'signature',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
