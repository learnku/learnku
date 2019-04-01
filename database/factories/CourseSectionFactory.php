<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CourseSection::class, function (Faker $faker) {
    $data_time = $faker->date . $faker->time;

    return [
        'title' => $faker->name,
        'created_at' => $data_time,
        'updated_at' => $data_time,
    ];
});
