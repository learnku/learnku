<?php

use Illuminate\Database\Seeder;
use App\Models\BlogArticle;

class BlogArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $blog_articles = factory(BlogArticle::class)->times(50)->make()->each(function ($blog_article, $index) {
            if ($index == 0) {
                // $blog_article->field = 'value';
            }
        });

        BlogArticle::insert($blog_articles->toArray());
    }

}

