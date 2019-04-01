<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CourseArticle::class, function (Faker $faker) {
    $date_time = $faker->date . $faker->time;
    return [
        'title' => $faker->name,
        'body' => $faker->text(),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
