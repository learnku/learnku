<?php

namespace App\Observers;

use App\Models\BlogArticle;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogArticleObserver
{
    public function creating(BlogArticle $blog_article)
    {
        //
    }

    public function updating(BlogArticle $blog_article)
    {
        //
    }
}