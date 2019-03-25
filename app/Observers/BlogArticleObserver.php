<?php

namespace App\Observers;

use App\Models\BlogArticle;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogArticleObserver
{
    public function saving(BlogArticle $article)
    {
        $article->excerpt = make_excerpt($article->body);
    }
}
