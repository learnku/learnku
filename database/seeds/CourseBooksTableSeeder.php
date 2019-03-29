<?php

use Illuminate\Database\Seeder;
use App\Models\CourseBook;

class CourseBooksTableSeeder extends Seeder
{
    public function run()
    {
        $course_books = factory(CourseBook::class)->times(50)->make()->each(function ($course_book, $index) {
            if ($index == 0) {
                // $course_book->field = 'value';
            }
        });

        CourseBook::insert($course_books->toArray());
    }

}

