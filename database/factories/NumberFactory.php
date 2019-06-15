<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Number;
use Faker\Generator as Faker;

$factory->define(Number::class, function (Faker $faker) {
    return [
        'value' => $faker->unique()->numberBetween(1, 100000),
    ];
});
