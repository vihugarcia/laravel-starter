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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Widget::class, function ($faker) {

    $name = $faker->unique()->word . ' ' . $faker->unique()->word;
    $slug = str_slug($name, "-");
    $user_id = rand(1,4);

    return [
        'name' => $name,
        'slug' => $slug,
        'user_id' => $user_id,


    ];
});
