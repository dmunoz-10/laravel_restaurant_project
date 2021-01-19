<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Ingredient;
use Faker\Generator as Faker;

$factory->define(Ingredient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'provider' => $faker->name,
    ];
});
