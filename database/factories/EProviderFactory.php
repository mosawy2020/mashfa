<?php
/*
 * File name: EProviderFactory.php
 * Last modified: 2021.08.04 at 18:10:26
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */


use App\Models\Award;
use App\Models\EProvider;
use App\Models\Experience;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(EProvider::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Gardner Construction', 'Concrete', 'Masonry', 'House', 'Care Services', 'Security', 'Dentists', 'Epoxy Coating', 'Glass', 'Painting', 'Roofing', 'Sewer Cleaning', 'Architect']) . " " . $faker->company,
        'description' => $faker->text,
        'e_provider_type_id' => $faker->numberBetween(2, 3),
        'phone_number' => $faker->phoneNumber,
        'mobile_number' => $faker->phoneNumber,
        'availability_range' => $faker->randomFloat(2, 6000, 15000),
        'available' => $faker->boolean(95),
        'featured' => $faker->boolean(40),
        'accepted' => $faker->boolean(95),
        'speciality_id' => $faker->numberBetween(2, 3),

    ];
});
