<?php

use Faker\Generator as Faker;

$factory->define(App\Models\BlogCategory::class, function (Faker $faker) {
    $data_time = $faker->date . ' ' . $faker->time;

    return [
        // 'name' => $faker->name,
        'description' => $faker->sentence(),
        'created_at' => $data_time,
        'updated_at' => $data_time,
    ];
});
