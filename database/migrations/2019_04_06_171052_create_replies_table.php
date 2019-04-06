<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->comment('评论内容');
            $table->tinyInteger('verify')->unsigned()->default(0)->index()->comment('审核');
            $table->integer('article_id')->unsigned()->default(0)->index()->comment('文章 ID');
            $table->integer('user_id')->unsigned()->default(0)->index()->comment('用户 ID');
            $table->string('model')->index()->comment('例：App\Models\Article');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
