<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BlogCategory;

class BlogCategoryPolicy extends Policy
{
    public function update(User $user, BlogCategory $blog_category)
    {
        return $blog_category->user_id == $user->id;
    }

    public function destroy(User $user, BlogCategory $blog_category)
    {
        return $blog_category->user_id == $user->id;
    }
}
