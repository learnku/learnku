<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogArticle;

class BlogArticlePolicy extends Policy
{
    public function update(User $user, BlogArticle $article)
    {
        // return $article->user_id == $user->id;
        return $user->isAuthorOf($article);
    }

    public function destroy(User $user, BlogArticle $article)
    {
        return $user->isAuthorOf($article);
    }
}
