<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesTable extends Migration 
{
	public function up()
	{
		Schema::create('blog_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->comment('名称');
            $table->text('description')->nullable()->comment('描述');
            $table->integer('post_count')->default(0)->comment('文章数');
            $table->tinyInteger('cascade')->default(0)->comment('归类=> 0:顶级分类');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('blog_categories');
	}
}
