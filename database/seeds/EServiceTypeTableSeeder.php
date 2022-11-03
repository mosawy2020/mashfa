<?php
/*
 * File name: EProvidersTableSeeder.php
 * Last modified: 2021.03.02 at 11:28:53
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use App\Models\EProvider;
use App\Models\EProviderUser;
use App\Models\EServiceType;
use Illuminate\Database\Seeder;

class EServiceTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('e_service_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(EServiceType::class, 18)->create();

    }
}
