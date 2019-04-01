<?php

namespace App\Models;

class CourseBook extends Model
{
    protected $fillable = ['title', 'excerpt'];

    /**
     * 获取文章章节
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        return $this->hasMany(CourseSection::class)->with('articles');
    }
}
