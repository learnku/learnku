<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['content'];

    public function article()
    {
        switch ($this->model) {
            case BlogArticle::class:
                return $this->belongsTo(BlogArticle::class);
                break;
            case CourseArticle::class:
                return $this->belongsTo(CourseArticle::class);
                break;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
