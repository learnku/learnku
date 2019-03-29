<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CourseArticle;

class CourseArticlePolicy extends Policy
{
    public function update(User $user, CourseArticle $course_article)
    {
        // return $course_article->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, CourseArticle $course_article)
    {
        return true;
    }
}
