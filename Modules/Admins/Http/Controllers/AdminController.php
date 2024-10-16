<?php

namespace Modules\Admins\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Admins\Http\Requests\AdminRequest;
use Modules\Admins\Http\Requests\AdminUpdateRequest;
use Modules\Admins\Services\AdminService;

class AdminController extends Controller
{

    private $adminService;
    public function __construct(AdminService $adminService) {
        $this->adminService = $adminService;
    }

    public function index() {
        $id = auth('admin-api')->user()->work_space_id;
        $admins = $this->adminService->index($id);
        return response()->json($admins[0], $admins[1]);
    }

    public function store(AdminRequest $request) {
        $id = auth('admin-api')->user()->work_space_id;
        $msg = $this->adminService->store($request,$id);
        return response()->json($msg[0], $msg[1]);
    }

    public function show($id) {
        $admin = $this->adminService->show($id);
        return response()->json($admin[0], $admin[1]);
    }

    public function getMe() {
        $admin = $this->adminService->getMe();
        return response()->json($admin[0],$admin[1]);
    }

    public function update(AdminUpdateRequest $request) {
        $admin = $this->adminService->update($request);
        return response()->json($admin[0], $admin[1]);
    }

    public function destroy($id) {
        $deleted = $this->adminService->delete($id);
        return response()->json($deleted[0], $deleted[1]);
    }
}
