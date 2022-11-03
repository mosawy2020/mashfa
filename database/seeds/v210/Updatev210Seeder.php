<?php
/*
 * File name: Updatev210Seeder.php
 * Last modified: 2022.04.16 at 13:30:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

use Illuminate\Database\Seeder;

class Updatev210Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppSettingsTableV210Seeder::class);
    }
}
