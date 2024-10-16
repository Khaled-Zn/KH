<?php

namespace Modules\Admins\Services;

use Exception;
use Modules\Shared\Models\Admin;
use Illuminate\Support\Facades\DB;
use Modules\Shared\Services\Role\BaseRoleService;

class AdminService {

    public function index($id) {
    
        $admins = Admin::with('roles:id,name')->where('work_space_id',$id)->get();
        foreach($admins as $admin) {
            $this->unsetRole($admin);
        }
        return [$admins,200];
    }
    // public function show($id) {

    //     $admin = Admin::with('roles:id,name')->where('id',$id)
    //     ->first();
    //     $ad = $admin->roles->first();
    //     unset($admin->roles);
    //     return [ [ 'admin' => $admin],200];
    // }
    public function store($request,$id) {

        DB::beginTransaction();
        $admin = Admin::create([
            'full_name' => $request->full_name,
            'email' =>  $request->email,
            'password' => bcrypt($request->password),
            'work_space_id' => $id
        ]);
        $admin->assignRole($request->role_id);
        DB::commit();
        $this->unsetRole($admin);
        return [$admin,200];
    }
    
    public function update($request) {

        $admin = Admin::findOrFail($request->id);
        if($request->has('role_id')) {
            DB::beginTransaction();
            $admin->update($request->except(['role_id'])); 
            $admin->syncRoles($request->role_id);
            DB::commit();
        }else {
            $admin->update($request->all()); 
        }
        
        $this->unsetRole($admin);
        return [$admin,200];
    }
    
    public function delete($id) {

        $deleted = Admin::where('id',$id)->delete();
        if(!$deleted) throw new Exception('There is no admin with id' .$id, 404);
        return [['message' => 'Role deleted successfully'],200];
    }

    public function getMe() {

        $admin = auth()->user();
        $this->unsetRole($admin);
        if($admin->role->name != 'super admin') { 
            $admin->permissions = (new BaseRoleService)->doesntHavePermissions($admin->role->id); 
        }
        return [$admin,200];
    }

    private function unsetRole($admin) {
        $role = $admin->roles->first();
        unset($admin->roles,$role->pivot,$role->created_at,$role->guard_name,$role->updated_at);
        $admin->role = $role;
    }
}