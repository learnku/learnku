<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 判断当前用户是否是作者
    public function isAuthorOf($model){
        return $model->user_id == $this->id;
    }

    /**
     * 关联
     */
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    // 对应回复
    public function replies()
    {
        return $this->hasMany(BlogReply::class);
    }

    /**
     * 获取将存储在JWT的主题声明中的标识符。
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 返回一个键值数组，包含要添加到JWT的任何自定义声明。
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
