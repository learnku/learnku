<?php

namespace App\Models;

class CourseSection extends Model
{
    protected $fillable = ['title', 'course_books_id'];

    /**
     * 章节对应的文章
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(CourseArticle::class);
    }

    /**
     * 对应的书籍
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(CourseBook::class, 'course_book_id', 'id');
    }
}
