<?php

use Illuminate\Database\Seeder;
use App\Models\CourseArticle;

class CourseArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        // 目录
        $sections = \App\Models\CourseSection::all()->pluck('id')->toArray();

        $course_articles = factory(CourseArticle::class)
            ->times(100)
            ->make()
            ->each(function ($course_article, $index) use ($faker, $sections){
                $course_article->course_section_id = $faker->randomElement($sections);
                $course_article->user_id = 1;
            });

        CourseArticle::insert($course_articles->toArray());
    }

}

