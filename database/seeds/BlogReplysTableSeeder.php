<?php

use Illuminate\Database\Seeder;
use App\Models\BlogReply;
use App\Models\User;
use App\Models\BlogArticle;

class BlogReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 所有用户 ID 数组
        $user_ids = User::all()->pluck('id')->toArray();

        // 所有文章
        $article_ids = BlogArticle::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(\Faker\Generator::class);

        $blog_replys = factory(BlogReply::class)
            ->times(1000)
            ->make()
            ->each(function ($blog_reply, $index) use ($user_ids, $article_ids, $faker){
                // 从用户 ID 数组中随机取出一个并赋值
                $blog_reply->user_id = $faker->randomElement($user_ids);

                $blog_reply->article_id = $faker->randomElement($article_ids);
            });

        BlogReply::insert($blog_replys->toArray());
    }

}

