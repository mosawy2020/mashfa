<?php
/*
 * File name: AppSettingsTableV123Seeder.php
 * Last modified: 2021.10.24 at 21:38:47
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class AppSettingsTableV123Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_settings')->insert(array(
            array(
                'key' => 'enable_paymongo',
                'value' => '1',
            ),
            array(
                'key' => 'paymongo_key',
                'value' => 'pk_test_iD6aYYm4yFuvkuisyU2PGSYH',
            ),
            array(
                'key' => 'paymongo_secret',
                'value' => 'sk_test_oxD79bMKxb8sA47ZNyYPXwf3',
            ),
        ));


    }
}
