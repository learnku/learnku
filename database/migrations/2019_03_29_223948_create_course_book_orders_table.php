<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseBookOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_book_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flag')->unsigned()->default(0)->index()->comment('0:待支付，1：已支付');
            $table->integer('user_id')->unsigned()->index()->comment('用户 id');
            $table->integer('course_book_id')->unsigned()->index()->comment('教程书籍 id');
            $table->string('payment_id')->nullable()->comment('支付 ID');
            $table->string('wx_out_trade_no')->nullable()->comment('微信支付 out_trade_no');
            $table->string('wx_code_url')->nullable()->comment('微信支付 code_url');
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
        Schema::dropIfExists('course_book_orders');
    }
}
