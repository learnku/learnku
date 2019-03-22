<?php

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorysTableSeeder extends Seeder
{
    public function run()
    {
        $blog_categorys = factory(BlogCategory::class)->times(50)->make()->each(function ($blog_category, $index) {
            if ($index == 0) {
                // $blog_category->field = 'value';
            }
        });

        BlogCategory::insert($blog_categorys->toArray());
    }

}

