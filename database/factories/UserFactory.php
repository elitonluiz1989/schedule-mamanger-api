<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Modules\Users\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->imageUrl(),
        'password' => 'secret',
        'role_id' => factory(Role::class, 1)->create()->first()->id,
        'api_token' => Str::random(10),
    ];
});
