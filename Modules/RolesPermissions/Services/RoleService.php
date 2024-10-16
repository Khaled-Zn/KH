<?php

namespace Modules\RolesPermissions\Services;

use Modules\Shared\Services\Role\BaseRoleService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleService extends BaseRoleService {
  
    public function index() {
        
        $roles = Role::query()->select('id','name')->get();
        return [$roles, 200];
    }
    public function show($id) {

        $role = Role::select('id','name')->find($id);
        if(!$role) return [['error' => 'Role do not exist'],404];
        $permissionsSelected = $this->permissionsSelected($id);
        $permissions = $this->getPermissions();
        return [['role' => $role,
                 'permissions' => $permissions,
                 'permissionsSelected' => $permissionsSelected],
                200];
    }    
    public function store($request) {

        $permissionsArray = $request->permissions;
        $validatePrmissions = $this->validatePrmissions($permissionsArray);
        if(is_array($validatePrmissions)) return $validatePrmissions;
        $role = Role::create(['name' => $request->name,'guard_name' => 'admin-api']);
        $role->syncPermissions($request->permissions);
        return [['msg' => 'Role created successfully'],200];
    }   
    public function update($request) {

        $permissionsArray = $request->permissions;
        $validatePrmissions = $this->validatePrmissions($permissionsArray);
        if(is_array($validatePrmissions)) return $validatePrmissions;
        $role = Role::find($request->id);
        if(!$role) return [['error' => 'Role do not exist'],404];
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($permissionsArray);
        return [['msg' => 'Role updated successfully'],200];
    }
    private function validatePrmissions($permissionsArray) {

        $permissions = Permission::whereIn('id',$permissionsArray)->pluck('id');
        if($permissions->isEmpty()) return [['error' => 'Permissions do not exist'],404];
        if(count($permissions) != count($permissionsArray)) {
            $idDiff = array_diff($permissionsArray,$permissions->toArray());
            return [['error' => "This ids do not exist",
                     'ids' =>  array_values($idDiff)
                    ],404];
        }
        return true;
    }
    public function destroy($id) {

        $deleted = Role::where('id', $id)->delete();
        if($deleted) return [['msg' => 'Role deleted successfully'],200];
        return [['error' => 'Role do not exist'],404];
    }
    public function getPermissions() {

        $permissions = $this->permissionQuery();
        $permissions = $this->groupPermissions($permissions);
        return [$permissions ,200];
    }

}