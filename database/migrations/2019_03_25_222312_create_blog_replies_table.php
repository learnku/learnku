<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogRepliesTable extends Migration 
{
	public function up()
	{
		Schema::create('blog_replies', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned()->default(0)->index();
            $table->integer('user_id')->unsigned()->default(0)->index();
            $table->text('content');
            $table->tinyInteger('verify')->unsigned()->default(0)->index()->comment('审核');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('blog_replies');
	}
}
