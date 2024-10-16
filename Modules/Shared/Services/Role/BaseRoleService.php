<?php
namespace Modules\Shared\Services\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BaseRoleService {

    protected function groupPermissions($permissions) {

        $permissionKeys = $permissions->keys();
        $permissions =  $permissions->values()->each(function($arrayOfPermission) {
            $arrayOfPermission->each(function($permission){
                unset($permission->resourceName);
            });
        });
        $endPermissions = [];
        for ($i=0; $i < count($permissionKeys); $i++) { 
            $endPermissions[] = ['resourceName' => $permissionKeys[$i],
                                 'permissions'  => $permissions[$i]]; 
        }
        return $endPermissions;
    }
    protected function permissionQuery($ids = null) {
        
        $permissionsQuery = Permission::join('resources as re','permissions.resource_id','=','re.id');
        if($ids) $permissionsQuery = $permissionsQuery->whereNotIn('permissions.id',$ids);
        $permissions = $permissionsQuery->select('permissions.id as permissionId',
        'permissions.name as permissionName',
        're.name as resourceName')
        ->get()->groupBy('resourceName');
        return $permissions;
    }
    public function doesntHavePermissions($id) {
        $permissions =  DB::table('role_has_permissions as rhp')
                        ->where("rhp.role_id",$id)
                        ->pluck("rhp.permission_id");
        $doesntHavePermissions = $this->groupPermissions($this->permissionQuery($permissions));
        $arrayOfPermission = config('permission.permissions');
        $notDoing = [];
        $cutPermission = null;
        foreach($doesntHavePermissions as &$permissionObj) {

            if(Count($arrayOfPermission[$permissionObj['resourceName']])
                == Count($permissionObj['permissions'])
            ) {
                $permissionObj['canEnter'] = false;
            }else {

                $permissionObj['canEnter'] = true;
                foreach($permissionObj['permissions'] as $permission) {
                    $cutPermission = Str::before($permission->permissionName, ' ');
                    $notDoing[] = ['id' => $permission->permissionId,
                    'name' => $cutPermission];
                }
                $permissionObj['notDoing'] = $notDoing;
            }
            
            unset($permissionObj['permissions']);
               
        }
        return $doesntHavePermissions;
    }

}