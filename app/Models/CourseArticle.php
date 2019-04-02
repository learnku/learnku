<?php

namespace App\Models;

class CourseArticle extends Model
{
    protected $fillable = ['title', 'body', 'slug', 'policy'];

    /**
     * 获取对应章节
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id', 'id');
    }

    /**
     * 对应用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
