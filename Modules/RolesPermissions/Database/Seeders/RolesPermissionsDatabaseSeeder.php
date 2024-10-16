<?php

namespace Modules\RolesPermissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\RolesPermissions\Entities\Resource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Modules\Shared\Models\Admin;

class RolesPermissionsDatabaseSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run() {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayOfPermissions = config('permission.permissions');

        $arrayOfResources = array_keys($arrayOfPermissions);
        $resources = collect($arrayOfResources)->map(function($resource){
            return ['name' => $resource];
        });
        Resource::insert($resources->toArray());

        $resources = Resource::select('id')->orderBy('id', 'asc')->pluck('id');
        $arrayOfPermissions = array_values($arrayOfPermissions);
        $permissions = [];
        for($resource = 0; $resource < count($resources); $resource++) {
            for($permission = 0; $permission < count($arrayOfPermissions[$resource]); $permission++) {
                $permissions[] = ['name' => $arrayOfPermissions[$resource][$permission] , 'guard_name' => 'admin-api',
                                  'resource_id' => $resources[$resource]];
            }
        }
        Permission::insert($permissions);

        $role1 = Role::create(['name' => 'reception','guard_name' => 'admin-api']);
        $role1->givePermissionTo('show admins');
        $role2 = Role::create(['name' => 'super admin','guard_name' => 'admin-api']);

        $user = Admin::create([
            'email' => 'admin@admin.com',
            'full_name' => 'ahmed-dwery',
            'password' => bcrypt('password'),
            'work_space_id'=>'1'
        ]);
        $user->assignRole($role1);

        $user = Admin::create([
            'email' => 'super-admin@super-admin.com',
            'full_name' => 'ahmed-dwery',
            'password' => bcrypt('password'),
            'work_space_id'=>'1'
        ]);
        $user->assignRole($role2);
    }
}
