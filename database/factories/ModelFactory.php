<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'credit' => $faker->numberBetween(0,50),
        'followers_left' => $faker->numberBetween(0,100)
    ];

});


$factory->define(App\Media::class, function (Faker\Generator $faker) {
    return [
        'url' => $faker->url,
        'user_id' => $faker->numberBetween(1,10),
        'likes_left' => $faker->numberBetween(0,100)
    ];

});
