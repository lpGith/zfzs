<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Model\User::class, function (Faker $faker) {
    return [
        'username'=>$faker->userName,
        'password'=>bcrypt('admin123'),
        'phone'=>$faker->phoneNumber,
        'email'=>$faker->email,
        'gender'=>['male','female'][rand(0,1)]
    ];
});
