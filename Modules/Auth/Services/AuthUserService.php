<?php

namespace Modules\Auth\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Shared\Enums\UserType;
use Modules\Auth\Mail\VerificationEmail;
use Modules\Shared\Models\User;
use Exception;
use Modules\Unregistered\Models\Unregistered;


class AuthUserService {

    public function signUp($request) {
        $verified = UserType::not_verified;
        $info_complete_step_one = UserType::info_not_completed;
        $info_complete_step_two = UserType::info_not_completed;

        $number = str_replace(' ', '', $request['number']);
        $user = User::create([
            'number' => $number,
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'email_verification_token' => Str::random(8)
        ]);


        $token = $user->createToken('token')->plainTextToken;
        $user->update([
            'remember_token' => $token
        ]);

        $unregister = Unregistered::where('number', $request['number'])->first();

        if ($unregister != null){
            $clients = $unregister->clients;
            foreach ($clients as $client) {
                $client->update([
                    'clientable_id' => $user->id,
                    'clientable_type' => get_class($user)
                ]);
            }
            $unregister->delete();
        }

        if ($user->hasVerifiedEmail()) {
            $verified = UserType::verified;
        }
        if ($user->full_name)
        {
            $info_complete_step_one = UserType::info_completed;
        }
        if ($user->residence_id)
        {
            $info_complete_step_two = UserType::info_completed;
        }

        Mail::to($user->email)->send(new VerificationEmail($user));

        return [
            'verifiedEmail' => $verified,
            'token' => $token,
            'email' => $user->email,
            'complete_info_step_one' => $info_complete_step_one,
            'complete_info_step_two' => $info_complete_step_two,
        ];
    }

    public function login($request) {

        $verified = UserType::not_verified;
        $info_complete_step_one = UserType::info_not_completed;
        $info_complete_step_two = UserType::info_not_completed;
        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            throw new Exception('invalid email', 401);
        }

        if (!Hash::check($request['password'], $user->password)) {
            throw new Exception('wrong password', 401);
        }

        $token = $user->createToken('token')->plainTextToken;
        $user->update([
            'remember_token' => $token
        ]);

        if ($user->hasVerifiedEmail()) {
            $verified = UserType::verified;
        }

        if ($user->full_name)
        {
            $info_complete_step_one = UserType::info_completed;
        }
        if ($user->residence_id)
        {
            $info_complete_step_two = UserType::info_completed;
        }

        return [ [
            'verifiedEmail' => $verified,
            'token' => $token,
            'email' => $user->email,
            'complete_info_step_one' => $info_complete_step_one,
            'complete_info_step_two' => $info_complete_step_two,
        ] ,200];
    }

    public function logout() {
        auth()->user()->tokens()->delete();
    }

    public function get_me(){

        $user = auth()->user()->load(['residence','talents','study']);
        return $user;
    }

}
