<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->comment('广告图 url 地址');
            $table->string('alt')->comment('图片 Alt信息');
            $table->string('bg_color')->nullable()->comment('背景色');
            $table->string('url')->comment('要跳转的链接地址');
            $table->string('title')->nullable()->comment('标题');
            $table->boolean('show')->default(true)->comment('是否显示');
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
        Schema::dropIfExists('banners');
    }
}
