<?php


namespace Modules\Unregistered\Service;


use Modules\Client\Models\Client;
use Modules\CompleteInfo\Models\Education;
use Modules\CompleteInfo\Models\Residence;
use Modules\CompleteInfo\Models\Speciality;
use Modules\CompleteInfo\Models\Talent;
use Modules\Shared\Enums\UserType;
use Modules\Unregistered\Models\TalentUnregistered;
use Modules\Unregistered\Models\Unregistered;
use Exception;

class UnregisteredCompleteInfoService
{
    public function CompleteInfo($request){
        $request->validate([
            'client_id' => 'required',
            'username' => 'required|string|between:4,100',
            'age' => 'required|date',
            'email' => 'required|unique:unregistereds|email',
            'study_type' => 'required|string',
            'residence_id' => 'required|integer',
            'talents_ids' => 'required',
        ]);
        if ($request['study_type'] == 'speciality')
        {
            $request->validate(['study_id' => 'required|integer']);
        }
        $admin = auth()->user();
        $client = Client::find($request->client_id);
        if (!$client){
            throw new Exception('Client is not found', 404);
        }
        if ($client->work_space_id != $admin->work_space_id){
            throw new Exception('Client is not from this work space',401);
        }

        if ($client->clientable_type != 'Modules\Unregistered\Models\Unregistered'){
            throw new Exception('Client is Registered',403);
        }
        $user = $client->clientable;
        if ($user->email){
            throw new Exception('Client is Registered',403);
        }

        if(!Residence::find($request['residence_id']))
        {
            throw new Exception('residence is not in table',404);
        }
        foreach ($request['talents_ids'] as $talent_id)
        {
            if (!Talent::find($talent_id))
            {
                throw new Exception('talent is not in table',404);
            }
        }
        if ($request['study_type'] == 'speciality')
        {
            if(!Speciality::find($request['study_id']))
            {
                throw new Exception('speciality is not in table',404);
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
            throw new Exception('type is not correct',409);
        }
        $user->update([
            'residence_id' => $request['residence_id'],
        ]);
        foreach ($request['talents_ids'] as $talent_id)
        {
            TalentUnregistered::create([
                'unregistered_id' => $user->id,
                'talent_id' => $talent_id,
            ]);
        }
        $user->update([
            'username' => $request['username'],
            'age' => $request['age'],
            'email' => $request['email'],
        ]);
        return [['msg' => 'info is completed successfully'],200];
    }
}
