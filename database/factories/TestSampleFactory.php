<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Tests\Models\Core\TestSampleModel;

$factory->define(TestSampleModel::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'age' => $faker->randomDigitNotNull
    ];
});
