<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTagsLinkArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags_link_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->comment('文章id')->unsigned();
            $table->integer('tag_id')->unsigned()->comment('标签id');
            $table->integer('user_id')->unsigned()->index()->comment('用户id, 对应article->user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_tags_link_articles');
    }
}
