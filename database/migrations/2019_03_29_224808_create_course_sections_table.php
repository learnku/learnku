<?php

/**
 * 教程书籍 章节表
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSectionsTable extends Migration 
{
	public function up()
	{
		Schema::create('course_sections', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('章节名称');
            $table->integer('course_book_id')->unsigned()->index()->comment('教程书籍 id');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('course_sections');
	}
}
