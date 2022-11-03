<?php

use Illuminate\Database\Seeder;
use App\Models\Speciality;

class SpecialityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialities')->delete();
        factory(Speciality::class, 20)->create();
    }
}
