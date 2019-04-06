<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 本地才允许 seed
        if (app()->isLocal()) {
            $this->call(UsersTableSeeder::class);
            $this->call(BlogCategorysTableSeeder::class);
		    $this->call(BlogArticlesTableSeeder::class);
            $this->call(CourseBooksTableSeeder::class);
            $this->call(CourseSectionsTableSeeder::class);
            $this->call(CourseArticlesTableSeeder::class);
        }
    }
}
