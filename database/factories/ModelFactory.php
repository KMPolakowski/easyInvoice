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

use Faker\Generator as Faker;

$factory->define(App\Invoice::class, function (Faker $faker) {
    return [
        'date' => $faker->date,
        'number' => $faker->numberBetween(0, 500),
        'topic' => $faker->text(60),
        'street' => $faker->streetName,
        'zip_code' => $faker->postcode,
        'house_number' => $faker->buildingNumber,
        'netto_sum' => $faker->numberBetween(350, 100000),
        'vat_percentage' => $faker->numberBetween(13, 20),
        'vat_sum' => $faker->numberBetween(50, 20000),
        'brutto_sum'=>  $faker->numberBetween(400, 120000)
    ];
});

$factory->define(App\User::class, function (Faker $faker) {
    return [

    ];
});
