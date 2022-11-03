<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Speciality;
use Faker\Generator as Faker;

$factory->define(Speciality::class, function (Faker $faker) {
   $services = [
        'Suger',
        'Eyes',
        'Heart',
        'General Surgery',
        'Gynecologist and Obstetrician',
        'Nurse Service',
    ];
    
    $price = $faker->randomFloat(2, 10, 20);
    return ['name' => $faker->randomElement($services)];
});
