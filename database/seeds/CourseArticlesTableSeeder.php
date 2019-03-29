<?php

use Illuminate\Database\Seeder;
use App\Models\CourseArticle;

class CourseArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $course_articles = factory(CourseArticle::class)->times(50)->make()->each(function ($course_article, $index) {
            if ($index == 0) {
                // $course_article->field = 'value';
            }
        });

        CourseArticle::insert($course_articles->toArray());
    }

}

