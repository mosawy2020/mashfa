<?php
/*
 * File name: PermissionsTableV200Seeder.php
 * Last modified: 2022.04.02 at 07:26:36
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableV200Seeder extends Seeder
{

    private $onlyControllers = [
        'ModuleController',
    ];

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            if ($this->match($route)) {
                // PermissionDoesNotExist
                try {
                    Permission::findOrCreate($route->getName(), 'web');
                    // give permissions to admin role
                    Role::findOrFail(2)->givePermissionTo($route->getName());
                } catch (Exception $e) {
                    Log::error($e);
                }
            }
        }
    }

    private function match($route)
    {
        if ($route->getName() === null) {
            return false;
        } else {
            if (preg_match('/API/', class_basename($route->getController()))) {
                return false;
            }
            if (in_array(class_basename($route->getController()), $this->onlyControllers)) {
                return true;
            }
        }
        return false;
    }
}
