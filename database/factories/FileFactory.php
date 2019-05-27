<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\File;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->slug,
        'name' => $faker->slug,
        'size' => $faker->numberBetween(1000, 10000000),
        'is_image' => $faker->randomElement([0, 1]),
        'nsfw_score' => $faker->randomFloat(4, 0, 0.9999),
        'expires_at' => now()->addHours(7),
    ];
});
