<?php
/*
 * File name: Updatev126Seeder.php
 * Last modified: 2022.01.19 at 00:02:46
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

use Illuminate\Database\Seeder;

class Updatev126Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_settings')->insert(array(
            array(
                'key' => 'default_country_code',
                'value' => 'DE',
            ),
        ));
    }
}
