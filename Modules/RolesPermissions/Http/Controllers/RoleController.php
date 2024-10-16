<?php

namespace Modules\RolesPermissions\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Modules\RolesPermissions\Http\Requests\RoleRequest;
use Modules\RolesPermissions\Services\RoleService;

class RoleController extends Controller
{
    protected $roleService; 
    public function __construct(RoleService $roleService) {
        $this->roleService = $roleService;
    }  
    public function index() {
        
        $roles = $this->roleService->index();
        return response()->json($roles[0], $roles[1]);
    }
    public function show($id) {

        $data = $this->roleService->show($id);
        return response()->json($data[0], $data[1]);
    }
    public function store(RoleRequest $request) {

       $role = $this->roleService->store($request);
        return response()->json($role[0], $role[1]); 
    }
    public function update(RoleRequest $request) {
        
        $updated = $this->roleService->update($request);
        return response()->json($updated[0], $updated[1]);
    }
    public function destroy($id) {

       $deleted = $this->roleService->destroy($id);
       return response()->json($deleted[0], $deleted[1]); 
    }
    public function getPermissions() {
        $permissions = $this->roleService->getPermissions();
        return response()->json($permissions[0], $permissions[1]); 
    }
}
