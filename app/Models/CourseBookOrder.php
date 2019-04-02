<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseBookOrder extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(CourseBook::class, 'course_book_id');
    }
}
