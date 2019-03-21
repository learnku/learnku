<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('gender')->nullable()->comment('性别: 0-女|1-男');
            $table->string('github_name')->nullable()->comment('GitHub Name');
            $table->string('real_name')->nullable()->comment('真实姓名');
            $table->string('city')->nullable()->comment('城市');
            $table->string('company')->nullable()->comment('公司或组织名称');
            $table->string('jobtitle')->nullable()->comment('职位头衔');
            $table->string('personal_website')->nullable()->comment('个人网站');
            $table->string('wechat_qrcode')->nullable()->comment('微信账号二维码');
            $table->string('payment_qrcode')->nullable()->comment('支付二维码');
            $table->string('introduction')->nullable()->comment('个人简介');
            $table->string('signature')->nullable()->comment('署名');
            $table->string('avatar')->nullable()->comment('头像: 暂不启用');
            $table->integer('image_id')->nullable()->unsigned()->index()->comment('头像对应的图片表 id ');
            $table->integer('user_id')->unsigned()->index()->comment('用户id');

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
        Schema::dropIfExists('user_infos');
    }
}
