<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'user_id' => function (){
            return factory(\App\User::class)->create()->id;
        },
        'title' => 'Title '. $faker->randomNumber(2),
        'content' => $faker->realText(180), // password
    ];
});
