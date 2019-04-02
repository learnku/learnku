<?php
/**
 * 教程 书籍表
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
            $table->decimal('prices', 8, 2)->default(19.99)->comment('价格');
            $table->integer('user_id')->unsigned()->index()->comment('用户 id');
            $table->integer('image_id')->unsigned()->index()->nullable()->comment('封面图 id');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('course_books');
	}
}
