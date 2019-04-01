<?php

namespace App\Models;

class CourseBook extends Model
{
    protected $fillable = ['title', 'excerpt' ,'image_id'];

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
}
