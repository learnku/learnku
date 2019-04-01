<?php

/**
 * 教程书籍 文章表
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseArticlesTable extends Migration 
{
	public function up()
	{
		Schema::create('course_articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('标题：充当目录');
            $table->text('body')->comment('内容');
            $table->integer('reply_count')->unsigned()->default(0)->comment('回复数');
            $table->integer('view_count')->unsigned()->default(0)->comment('查看数');
            $table->string('slug')->nullable()->comment('友好SEO');
            $table->integer('course_section_id')->unsigned()->index()->comment('教程章节 id');
            $table->integer('user_id')->unsigned()->index()->comment('用户 id');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('course_articles');
	}
}
