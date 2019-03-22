<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogArticle;

class BlogArticlePolicy extends Policy
{
    public function update(User $user, BlogArticle $blog_article)
    {
        // return $blog_article->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, BlogArticle $blog_article)
    {
        return true;
    }
}
