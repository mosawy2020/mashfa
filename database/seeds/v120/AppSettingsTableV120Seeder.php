<?php
/*
 * File name: AppSettingsTableV120Seeder.php
 * Last modified: 2021.07.31 at 14:00:06
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class AppSettingsTableV120Seeder extends Seeder
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
                'key' => 'enable_paystack',
                'value' => '1',
            ),
            array(
                'key' => 'paystack_key',
                'value' => 'pk_test_d754715fa3fa9048c9ab2832c440fb183d7c91f5',
            ),
            array(
                'key' => 'paystack_secret',
                'value' => 'sk_test_66f87edaac94f8adcb28fdf7452f12ccc63d068d',
            ),
            array(
                'key' => 'enable_flutterwave',
                'value' => '1',
            ),
            array(
                'key' => 'flutterwave_key',
                'value' => 'FLWPUBK_TEST-d465ba7e4f6b86325cb9881835726402-X',
            ),
            array(
                'key' => 'flutterwave_secret',
                'value' => 'FLWSECK_TEST-d3f8801da31fc093fb1207ea34e68fbb-X',
            ),
            array(
                'key' => 'enable_stripe_fpx',
                'value' => '1',
            ),
            array(
                'key' => 'stripe_fpx_key',
                'value' => 'pk_test_51IQ0zvB0wbAJesyPLo3x4LRgOjM65IkoO5hZLHOMsnO2RaF0NlH7HNOfpCkjuLSohvdAp30U5P1wKeH98KnwXkOD00mMDavaFX',
            ),
            array(
                'key' => 'stripe_fpx_secret',
                'value' => 'sk_test_51IQ0zvB0wbAJesyPUtR7yGdyOR7aGbMQAX5Es9P56EDUEsvEQAC0NBj7JPqFuJEYXrvSCm5OPRmGaUQBswjkRxVB00mz8xhkFX',
            ),
        ));


    }
}
