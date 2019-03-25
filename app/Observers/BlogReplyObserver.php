<?php

namespace App\Observers;

use App\Http\Controllers\Traits\Markdown;
use App\Models\BlogReply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogReplyObserver
{
    use Markdown;
    public function creating(BlogReply $reply)
    {
        $reply->content = $this->markdownToHtml($reply->content);
    }

    public function created(BlogReply $reply)
    {
        $reply->article->reply_count = $reply->article->replies->count();
        $reply->article->save();
    }
}
