<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    $faker->addProvider(new Xvladqt\Faker\LoremFlickrProvider($faker));
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 2),
        'description' => $faker->text($maxNbChars = 500),
        'journal_image' => $faker->image(storage_path('uploads/journals'),600, 600, false, false)
    ];
});
