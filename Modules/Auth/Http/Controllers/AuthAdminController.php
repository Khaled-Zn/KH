<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\LoginUserRequest;
use Modules\Auth\Services\AuthAdminService;

class AuthAdminController extends Controller {

    protected $AuthAdminService;
    public function __construct(AuthAdminService $AuthAdminService) {
        $this->AuthAdminService = $AuthAdminService;
    }

    public function login(LoginUserRequest $request) {

        $login = $this->AuthAdminService->login($request);
        return response()->json($login[0], $login[1]);
    }

    public function logout() {
        response()->json($this->AuthAdminService->logout(), 200);
    }

    public function get_me(){
        return response()->json($this->AuthAdminService->get_me(), 200);
    }


}
