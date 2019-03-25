<?php

namespace App\Models;

class BlogReply extends Model
{
    protected $fillable = ['content'];

    public function article(){
    	return $this->belongsTo(BlogArticle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
