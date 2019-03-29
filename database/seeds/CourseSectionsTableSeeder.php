<?php

use Illuminate\Database\Seeder;
use App\Models\CourseSection;

class CourseSectionsTableSeeder extends Seeder
{
    public function run()
    {
        $course_sections = factory(CourseSection::class)->times(50)->make()->each(function ($course_section, $index) {
            if ($index == 0) {
                // $course_section->field = 'value';
            }
        });

        CourseSection::insert($course_sections->toArray());
    }

}

