<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannerUrlToCourseBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_books', function (Blueprint $table) {
            $table->string('banner_url')->nullable()->after('image_id')->comment('广告图 Url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_books', function (Blueprint $table) {
            $table->dropColumn('banner_url');
        });
    }
}
