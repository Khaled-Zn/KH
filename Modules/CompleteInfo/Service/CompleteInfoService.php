<?php

namespace Modules\CompleteInfo\Service;

use http\Env\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\CompleteInfo\Models\Residence;
use Modules\CompleteInfo\Models\Speciality;
use Modules\CompleteInfo\Models\Education;
use Modules\CompleteInfo\Models\Talent;
use Modules\CompleteInfo\Models\TalentUser;
use Modules\Shared\Enums\UserType;
use Modules\Auth\Mail\VerificationEmail;
use Modules\Shared\Models\User;

class CompleteInfoService {
    public function CompleteInfoStepOne($request){
        $user = auth()->user();
        $verified = UserType::not_verified;
        $info_complete_step_one = UserType::info_not_completed;
        $info_complete_step_two = UserType::info_not_completed;
        if ($user->hasVerifiedEmail()) {
            $verified = UserType::verified;
        }
        if ($user->residence_id)
        {
            $info_complete_step_two = UserType::info_completed;
        }
        if ($user->full_name)
        {
            $info_complete_step_one = UserType::info_completed;
            return [
                'verifiedEmail' => $verified,
                'complete_info_step_one' => $info_complete_step_one,
                'complete_info_step_two' => $info_complete_step_two,
                'token' => $user->remember_token,
                'email' => $user->email
            ];
        }

        $user->update([
            'full_name' => $request['full_name'],
            'username' => $request['username'],
            'age' => $request['age'],
        ]);
        $info_complete_step_one = UserType::info_completed;
        return [
            'verifiedEmail' => $verified,
            'complete_info_step_one' => $info_complete_step_one,
            'complete_info_step_two' => $info_complete_step_two,
            'token' => $user->remember_token,
            'email' => $user->email
        ];
    }
    public function CompleteInfoStepTwo($request){
        if ($request['study_type'] == 'speciality')
        {
            $request->validate([
                'study_id' => 'required',
            ]);
        }
        $user = auth()->user();
        $verified = UserType::not_verified;
        $info_complete_step_one = UserType::info_not_completed;
        $info_complete_step_two = UserType::info_not_completed;

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
            return [
                'verifiedEmail' => $verified,
                'complete_info_step_one' => $info_complete_step_one,
                'complete_info_step_two' => $info_complete_step_two,
                'token' => $user->remember_token,
                'email' => $user->email
            ];
        }
        if(!Residence::find($request['residence_id']))
        {
            return [
                'error'=>'residence is not in table'
            ];
        }
        foreach ($request['talents_ids'] as $talent_id)
        {
            if (!Talent::find($talent_id))
            {
                return [
                    'error'=>'talent is not in table'
                ];
            }
        }
        if ($request['study_type'] == 'speciality')
        {
            if(!Speciality::find($request['study_id']))
            {
                return [
                    'error'=>'speciality is not in table'
                ];
            }
            else
            {
                $user->update([
                    'study_id' => $request['study_id'],
                    'study_type' => 'Modules\CompleteInfo\Models\Speciality'
                ]);
            }
        }
        else if ($request['study_type'] == 'education')
        {
            $user->update([
                'study_id' => Education::first()->id,
                'study_type' => 'Modules\CompleteInfo\Models\Education'
            ]);
        }
        else
        {
            return [
                'error'=>'type is not correct'
            ];
        }
        $user->update([
            'residence_id' => $request['residence_id'],
        ]);
        foreach ($request['talents_ids'] as $talent_id)
        {
            TalentUser::create([
                'user_id' => $user->id,
                'talent_id' => $talent_id,
            ]);
        }
        $info_complete_step_two = UserType::info_completed;
        return [
            'verifiedEmail' => $verified,
            'complete_info_step_one' => $info_complete_step_one,
            'complete_info_step_two' => $info_complete_step_two,
            'token' => $user->remember_token,
            'email' => $user->email
        ];
    }
    public function CompleteInfoStage(){
        $user = auth()->user();
        $verified = UserType::not_verified;
        $info_complete_step_one = UserType::info_not_completed;
        $info_complete_step_two = UserType::info_not_completed;
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
        return [
            'verifiedEmail' => $verified,
            'complete_info_step_one' => $info_complete_step_one,
            'complete_info_step_two' => $info_complete_step_two,
            'token' => $user->remember_token,
            'email' => $user->email,
        ];
    }
}
