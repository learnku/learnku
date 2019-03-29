<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticlesTable extends Migration 
{
	public function up()
	{
		Schema::create('blog_articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('帖子标题');
            $table->text('body')->comment('帖子内容');
            $table->integer('user_id')->unsigned()->index()->comment('用户 ID');
            $table->integer('category_id')->unsigned()->index()->comment('分类 ID');
            $table->integer('reply_count')->unsigned()->default(0)->comment('回复数量');
            $table->integer('view_count')->unsigned()->default(0)->comment('查看总数');
            $table->integer('vote_count')->unsigned()->default(0)->comment('喜欢总数-赞');
            $table->integer('last_reply_user_id')->unsigned()->default(0)->comment('最后回复的用户 ID');
            $table->integer('order')->unsigned()->default(0)->comment('可用来做排序使用');
            $table->text('excerpt')->nullable()->comment('文章摘要');
            $table->string('slug')->nullable()->comment('SEO7友好的 URI');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('blog_articles');
	}
}
