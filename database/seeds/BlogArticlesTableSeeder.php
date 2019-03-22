<?php

use Illuminate\Database\Seeder;
use App\Models\BlogArticle;
use App\Models\User;
use App\Models\BlogCategory;

class BlogArticlesTableSeeder extends Seeder
{
    public function run()
    {
        // 所有用户 ID 数组，如：[1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        // 所有分类 ID 数组，如：[1,2,3,4]
        $category_ids = BlogCategory::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(\Faker\Generator::class);

        $blog_articles = factory(BlogArticle::class)
            ->times(100)
            ->make()
            ->each(function ($blog_article, $index) use ($user_ids, $category_ids, $faker) {
                // 从用户 ID 数组中随机取出一个并赋值
                $blog_article->user_id = $faker->randomElement($user_ids);

                // 文章分类，同上
                $blog_article->category_id = $faker->randomElement($category_ids);
            });

        // 将数据集合转换为数组，并插入到数据库中
        BlogArticle::insert($blog_articles->toArray());
    }

}

