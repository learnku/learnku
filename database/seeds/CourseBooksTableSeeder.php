<?php

use Illuminate\Database\Seeder;
use App\Models\CourseBook;

class CourseBooksTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        $course_books = factory(CourseBook::class)
            ->times(5)
            ->make()
            ->each(function ($course_book, $index) use ($faker){
                $course_book->user_id = 1;
            });

        CourseBook::insert($course_books->toArray());
    }

}

