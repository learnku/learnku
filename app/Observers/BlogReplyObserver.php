<?php

namespace App\Observers;

use App\Models\BlogReply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogReplyObserver
{
    public function created(BlogReply $reply)
    {
        // $reply->article->reply_count = $reply->article->replies->count();
        // $reply->article->save();
    }
}
