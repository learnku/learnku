<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseBook extends Model
{
    protected $fillable = ['title', 'excerpt' , 'prices', 'image_id'];

    /**
     * 获取文章章节
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany(CourseSection::class)->with('articles');
    }

    /**
     * 封面图
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class)->select('id', 'path');
    }

    /**
     * 教程对应的订单
     */
    public function order()
    {
        // return $this->hasMany(CourseBookOrder::class)->where('course_book_orders.user_id', Auth::id());
        return $this->hasOne(CourseBookOrder::class)->where('course_book_orders.user_id', Auth::id());
    }
}
