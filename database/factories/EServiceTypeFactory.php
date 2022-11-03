<?php
/*
 * File name: EServiceFactory.php
 * Last modified: 2021.11.15 at 12:38:59
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

/** @var Factory $factory */

use App\Models\EProvider;
use App\Models\EService;
use App\Models\EServiceType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(EServiceType::class, function (Faker $faker) {
    $services = [
        'Full Home Deep Cleaning',
        'Post Party Cleaning',
        'Office Cleaning',
        'Tank Cleaning',
        'Suv Car Washing ',
        'Sedan Car Washing ',
        'Nurse Service',
        'Bathtub Refinishing',
        'Doctor at home Service',
        'Architect Service',
        'Hair Style Service',
        'Makeup & Beauty Services',
        'Massage Services',
        'Thai Massage Services',
        'Facials Services',
        'Photography Services',
        'Portrait Photos Services',
        'Wedding Photos',
        'Lawn Care Services',
        'Real Estate Agents',
        'Screens - New and Repair',
        'Flooring Services',
        'Deck Cleaning / Sealing'
    ];
    $price = $faker->randomFloat(2, 10, 50);
    $discountPrice = $price - $faker->randomFloat(2, 1, 10);
    return [
        'name' => $faker->randomElement($services),
        'description' => $faker->text,

    ];
});
