<?php
/*
 * File name: RoleHasPermissionsTableV123Seeder.php
 * Last modified: 2021.10.24 at 21:38:47
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class RoleHasPermissionsTableV123Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('role_has_permissions')->where('permission_id', '=', 210)->count() == 0) {
            DB::table('role_has_permissions')->insert(array(
                array(
                    'permission_id' => 210,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 211,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 212,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 213,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 214,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 215,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 216,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 217,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 218,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 216,
                    'role_id' => 3,
                ),
                array(
                    'permission_id' => 210,
                    'role_id' => 3,
                ),
                array(
                    'permission_id' => 216,
                    'role_id' => 4,
                ),
                array(
                    'permission_id' => 210,
                    'role_id' => 4,
                ),
            ));
        }


    }
}
