<?php

namespace App\Observers;

use App\Models\BlogReply;
use App\Notifications\BlogArticleReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogReplyObserver
{
    public function created(BlogReply $reply)
    {
        // $reply->article->reply_count = $reply->article->replies->count();
        // $reply->article->save();

        $reply->article->reply_count = $reply->article->replies->count();
        $reply->article->save();

        // 通知话题作者有新的评论
        $reply->article->user->notify(new BlogArticleReplied($reply));
    }
}
