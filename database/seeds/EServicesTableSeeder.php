<?php
/*
 * File name: EServicesTableSeeder.php
 * Last modified: 2021.03.01 at 21:22:30
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use App\Models\EService;
use App\Models\EServiceType;
use Illuminate\Database\Seeder;

class EServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
//        DB::table('e_services')->delete();
        for ($i =0 ; $i<1; $i++)
        EServiceType::create(["id"=>1,"name"=>"Medical consultation","description"=>"Medical consultation"]);

//        factory(EService::class, 40)->create();
    }
}
