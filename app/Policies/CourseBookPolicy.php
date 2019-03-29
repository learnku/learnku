<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CourseBook;

class CourseBookPolicy extends Policy
{
    public function update(User $user, CourseBook $course_book)
    {
        // return $course_book->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, CourseBook $course_book)
    {
        return true;
    }
}
