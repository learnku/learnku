<?php

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorysTableSeeder extends Seeder
{
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);
        $categorys = [
            'html', 'css', 'js', 'php', 'java', 'python', '.net', '.asp', 'myasql', 'centos',
        ];
        $user_ids = [1];

        $blog_categorys = factory(BlogCategory::class)
            ->times(10)
            ->make()
            ->each(function ($blog_category, $index) use ($categorys, $user_ids, $faker){
                $blog_category->name = $categorys[$index];
                $blog_category->user_id = $faker->randomElement($user_ids);
            });

        BlogCategory::insert($blog_categorys->toArray());
    }
}

