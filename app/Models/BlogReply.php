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

    // 更新回复总数
    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
