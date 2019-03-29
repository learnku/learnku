<?php

namespace App\Models;

class CourseArticle extends Model
{
    protected $fillable = ['title', 'body', 'reply_count', 'view_count', 'slug', 'course_books_id', ' courses_section_id', 'user_id'];
}
