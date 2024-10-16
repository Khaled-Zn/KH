<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Auth\Services\AuthUserService;
use Modules\Auth\Http\Requests\CreateUserRequest;
use Modules\Auth\Http\Requests\LoginUserRequest;

class AuthUserController extends Controller {

    private $AuthUserService;
    public function __construct(AuthUserService $AuthUserService )
    {
        $this->AuthUserService = $AuthUserService;
    }

    public function signUp(CreateUserRequest $request) {
        return response()->json($this->AuthUserService->signUp($request), 200);
    }

    public function login(LoginUserRequest $request) {
        $login = $this->AuthUserService->login($request);
        return response()->json($login[0] ,$login[1]);
    }

    public function logout() {
        $this->AuthUserService->logout();
    }

    public function get_me(){
        return response()->json($this->AuthUserService->get_me(), 200);
    }

}
