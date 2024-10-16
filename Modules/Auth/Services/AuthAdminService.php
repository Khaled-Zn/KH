<?php

namespace Modules\Auth\Services;

use Modules\Shared\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthAdminService {

    public function login($request) {

        $user = Admin::where('email', $request['email'])->first();
        if (!$user) {
            throw new Exception('invalid email', 401);
        }

        if (!Hash::check($request['password'], $user->password)) {
            throw new Exception('wrong password', 401);
        }

        $token = $user->createToken('token')->plainTextToken;
        return [
            ['token' => $token],200
        ];
    }
    public function logout() {
        auth()->user()->tokens()->delete();
    }


    public function get_me(){

        $admin = auth()->user();
        return [
            'admin' => $admin,
        ];
    }


}
