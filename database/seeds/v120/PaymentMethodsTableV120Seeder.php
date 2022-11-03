<?php
/*
 * File name: PaymentMethodsTableV120Seeder.php
 * Last modified: 2021.07.24 at 16:30:44
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class PaymentMethodsTableV120Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert(array(
            array(
                'id' => 8,
                'name' => 'PayStack',
                'description' => 'Click to pay with PayStack gateway',
                'route' => '/PayStack',
                'order' => 5,
                'default' => 0,
                'enabled' => 1,
                'created_at' => '2021-07-23 22:38:42',
                'updated_at' => '2021-07-23 22:38:42',
            ),
            array(
                'id' => 9,
                'name' => 'FlutterWave',
                'description' => 'Click to pay with FlutterWave gateway',
                'route' => '/FlutterWave',
                'order' => 6,
                'default' => 0,
                'enabled' => 1,
                'created_at' => '2021-07-23 22:38:42',
                'updated_at' => '2021-07-23 22:38:42',
            ),
            array(
                'id' => 10,
                'name' => 'Malaysian Stripe FPX	',
                'description' => 'Click to pay with Stripe FPX gateway',
                'route' => '/StripeFPX',
                'order' => 7,
                'default' => 0,
                'enabled' => 1,
                'created_at' => '2021-07-24 22:38:42',
                'updated_at' => '2021-07-24 22:38:42',
            ),
        ));


    }
}
