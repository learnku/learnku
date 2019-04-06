<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\ArticleReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->article->updateReplyCount();

        // 通知话题作者有新的评论
        $reply->article->user->notify(new ArticleReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->article->updateReplyCount();
    }
}
