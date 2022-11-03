<?php
/*
 * File name: PermissionsTableV121Seeder.php
 * Last modified: 2021.08.10 at 18:03:34
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class PermissionsTableV121Seeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('permissions')->insert(array(
            array(
                'id' => 210,
                'name' => 'wallets.index',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 211,
                'name' => 'wallets.create',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            )
        , array(
                'id' => 212,
                'name' => 'wallets.store',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 213,
                'name' => 'wallets.update',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 214,
                'name' => 'wallets.edit',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 215,
                'name' => 'wallets.destroy',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 216,
                'name' => 'walletTransactions.index',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 217,
                'name' => 'walletTransactions.create',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
            array(
                'id' => 218,
                'name' => 'walletTransactions.store',
                'guard_name' => 'web',
                'created_at' => '2021-02-24 11:37:44',
                'updated_at' => '2021-02-24 11:37:44',
            ),
        ));

    }
}
