<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Dish;
use Faker\Generator as Faker;

$factory->define(Dish::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween($min = 1, $max = 9999999999),
    ];
});
