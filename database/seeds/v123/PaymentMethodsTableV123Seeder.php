<?php
/*
 * File name: PaymentMethodsTableV123Seeder.php
 * Last modified: 2021.10.24 at 21:38:47
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class PaymentMethodsTableV123Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('payment_methods')->where('id', '=', 11)->count() == 0) {
            DB::table('payment_methods')->insert(array(
                array(
                    'id' => 11,
                    'name' => 'Wallet',
                    'description' => 'Click to pay with Wallet',
                    'route' => '/Wallet',
                    'order' => 8,
                    'default' => 0,
                    'enabled' => 1,
                    'created_at' => '2021-08-08 22:38:42',
                    'updated_at' => '2021-08-08 22:38:42',
                ),
            ));
        }
        DB::table('payment_methods')->insert(array(
            array(
                'id' => 12,
                'name' => 'PayMongo',
                'description' => 'Click to pay with PayMongo',
                'route' => '/PayMongo',
                'order' => 12,
                'default' => 0,
                'enabled' => 1,
                'created_at' => '2021-10-08 22:38:42',
                'updated_at' => '2021-10-08 22:38:42',
            ),
        ));


    }
}
