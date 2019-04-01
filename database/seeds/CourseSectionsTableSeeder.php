<?php

use Illuminate\Database\Seeder;
use App\Models\CourseSection;

class CourseSectionsTableSeeder extends Seeder
{
    public function run()
    {
        $course_sections = factory(CourseSection::class)
            ->times(50)
            ->make()
            ->each(function ($course_section, $index) {
                $course_section->course_book_id = 1;
            });

        CourseSection::insert($course_sections->toArray());
    }

}

