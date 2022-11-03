<?php
/*
 * File name: AppSettingsTableV210Seeder.php
 * Last modified: 2022.04.16 at 13:30:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

use Illuminate\Database\Seeder;

class AppSettingsTableV210Seeder extends Seeder
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
                'key' => 'enable_otp',
                'value' => '1',
            ),
        ));
    }
}
