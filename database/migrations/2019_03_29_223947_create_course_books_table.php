<?php
/**
 * 教程书籍表
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseBooksTable extends Migration 
{
	public function up()
	{
		Schema::create('course_books', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('教程名称');
            $table->text('excerpt')->nullable()->comment('教程简介');
            $table->integer('user_id')->unsigned()->index()->comment('用户 id');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('course_books');
	}
}
