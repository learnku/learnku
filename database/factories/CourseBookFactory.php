<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CourseBook::class, function (Faker $faker) {
    $data_time = $faker->date . ' ' . $faker->time;

    return [
        'title' => '教程' . $faker->name,
        'excerpt' => $faker->sentence(),
        'created_at' => $data_time,
        'updated_at' => $data_time,
    ];
});
