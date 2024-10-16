<?php

namespace Modules\Auth\Services;

use Modules\Shared\Enums\UserType;
use Modules\Shared\Models\User;
use Illuminate\Auth\Events\Verified;

use Exception;
class EmailVerificationService {

    public function VerifyEmail($token)
    {
        $info_complete_step_one = UserType::info_not_completed;
        $info_complete_step_two = UserType::info_not_completed;
        $user = User::where('email_verification_token', $token)->first();

        if ($user == null) {
            throw new Exception('wrong code', 401);
        }

        if ($user->markEmailAsVerified()) {

            event(new Verified($user));
        }

        $user->update([
            'email_verification_token' => ''
        ]);
        if ($user->full_name)
        {
            $info_complete_step_one = UserType::info_completed;
        }
        if ($user->residence_id)
        {
            $info_complete_step_two = UserType::info_completed;
        }
        return [[
            'verifiedEmail' => UserType::verified,
            'token' => $user->remember_token,
            'email' => $user->email,
            'complete_info_step_one' => $info_complete_step_one,
            'complete_info_step_two' => $info_complete_step_two,
            ]
            ,200];

    }

}
