<?php


namespace Modules\Log\Service;


use Carbon\Carbon;
use Exception;
use Modules\Client\Models\Client;
use Modules\Log\Models\DailyLog;
use Modules\Log\Models\Log;
use Modules\Shared\Models\User;
use Modules\Traffic\Models\Traffic;
use Modules\Unregistered\Models\Unregistered;
use Modules\WorkSpace\Models\WorkSpace;
use Nwidart\Modules\Collection;
use function PHPUnit\Framework\returnArgument;

class LogService
{
    public function FindUserByNumber($request){
        if (!$request->has('number') || $request->number == [])return[[],200];
        $number = $request->number;
        $unregisteredUsers = Unregistered::where('number','like','%'.$number.'%')->get();
        $registeredUsers = User::where('number','like','%'.$number.'%')->get();
        return [$unregisteredUsers->merge($registeredUsers),200];
    }

    public function CreateLog($request){
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $traffic = $workSpace->traffic;
        if(!$traffic){
            throw new Exception('Work Space traffic is not found', 404);
        }
        if ($traffic->count == $traffic->full){
            throw new Exception('Work Space is full', 409);
        }
        $workSpaceDailyLog = $workSpace->dailyLogs->last();
        if (!$workSpaceDailyLog) throw new Exception('Work Space don\'t have any daily log', 404);
        $request->validate([
            'created_at' => 'required|date',
            'number' => 'required|string|min:9'
        ]);
        $created_at = Carbon::create($request->created_at)->format('Y/m/d');
        if ($workSpaceDailyLog->created_at->format('Y/m/d') > $created_at) throw new Exception('created at date is in the past', 409);
        else if ($workSpaceDailyLog->created_at->format('Y/m/d') < $created_at) throw new Exception('Daily Log is not created yet', 409);
        if ($traffic->full == $traffic->count)
            throw new Exception('Work Space is full', 403);
        $user = $this->FindUserByNumber($request)[0]->first();
        if (!$user){
            $request->validate([
                'full_name' => 'required|regex:/^[a-zA-Z ]*$/'
            ]);
            $user = Unregistered::create([
                'full_name' => $request->full_name,
                'number' => $request->number,
            ]);
            $client = Client::create([
                'clientable_id' => $user->id,
                'clientable_type' => get_class($user),
                'work_space_id' => $admin->work_space_id,
            ]);
        } elseif ($user->clients->isEmpty()) {
            $client = Client::create([
                'clientable_id' => $user->id,
                'clientable_type' => get_class($user),
                'work_space_id' => $admin->work_space_id,
            ]);
        } else {
            $client = $user->clients->firstWhere('work_space_id', $admin->work_space_id);
            if (!$client){
                $client = Client::create([
                    'clientable_id' => $user->id,
                    'clientable_type' => get_class($user),
                    'work_space_id' => $admin->work_space_id,
                ]);
            }
        }
        $log = Log::create([
            'daily_log_id' => $workSpaceDailyLog->id,
            'client_id' => $client->id,
            'created_at' => $request->created_at
        ]);
        $traffic = traffic::where('work_space_id', $admin->work_space_id)->first();
        $traffic->update(['count' => ($traffic->count + 1)]);
        $flag = false;
        if ($log->client->clientable_type == Unregistered::class && !$log->client->clientable->email)$flag = true;
        return [[
            'client_id'=> $log->client->id,
            'name'=> $log->client->clientable->full_name,
            'number'=> $log->client->clientable->number,
            'editable'=> $flag,
        ],200];
    }
    public function DeleteLog(){
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $traffic = $workSpace->traffic;
        if(!$traffic){
            throw new Exception('Work Space traffic is not found', 404);
        }
        if ($traffic->count != 0){
            $traffic->update(['count' => ($traffic->count - 1)]);
            return [['msg' => 'Log has been deleted successfully'],200];
        }
        throw new Exception('Work Space is Empty', 409);
    }
    public function ShowLogs($request){
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $request->validate(['created_at' => 'required|date']);
        $created_at = Carbon::create($request->created_at)->format('Y/m/d');
        $clients = collect();
        foreach ($workSpace->dailyLogs as $dailyLog){
            if ($dailyLog->created_at->format('Y/m/d') == $created_at){
                $dailyLog->logs->each(function ($log, $key) use ($clients) {
                    $flag = false;
                    if ($log->client->clientable_type == Unregistered::class && !$log->client->clientable->email)$flag = true;
                    $clients->push([
                        'client_id'=> $log->client->id,
                        'name'=> $log->client->clientable->full_name,
                        'number'=> $log->client->clientable->number,
                        'editable'=> $flag,
                    ]);
                });
                break;
            }
        }
        return [$clients,200];
    }

}
