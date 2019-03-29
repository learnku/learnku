<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CourseSection;

class CourseSectionPolicy extends Policy
{
    public function update(User $user, CourseSection $course_section)
    {
        // return $course_section->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, CourseSection $course_section)
    {
        return true;
    }
}
