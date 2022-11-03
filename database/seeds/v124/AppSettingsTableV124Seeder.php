<?php
/*
 * File name: AppSettingsTableV124Seeder.php
 * Last modified: 2021.11.21 at 21:32:25
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class AppSettingsTableV124Seeder extends Seeder
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
                'key' => 'provider_app_name',
                'value' => 'Service Provider',
            ),
        ));
    }
}
