<?php


namespace Modules\Log\Service;

use Exception;
use Carbon\Carbon;
use Modules\Log\Models\DailyLog;
use Modules\WorkSpace\Models\WorkSpace;
use Modules\Log\Enums\DailyLogStatus;
use Modules\Log\Models\SalesLog;

class DailyLogService
{
    public function CreateDailyLog($request){
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $workSpaceDailyLog = $workSpace->dailyLogs->last();
        $request->validate(['created_at' => 'required|date']);
        $created_at = Carbon::create($request->created_at)->format('Y/m/d');
        if ($workSpaceDailyLog){
            if ($workSpaceDailyLog->created_at->format('Y/m/d') > $created_at) throw new Exception('created at date is in the past', 409);
            else if ($workSpaceDailyLog->created_at->format('Y/m/d') == $created_at) throw new Exception('Daily Log has been created', 409);
        }
        $traffic = $workSpace->traffic;
        if (!$traffic) throw new Exception('traffic is not found', 404);
        $dailyLog = DailyLog::create([
            'work_space_id' => $workSpace->id,
            'created_at' => $request->created_at
        ]);
        $traffic->update(['count' => 0]);
        foreach ($workSpace->menu->menuItems as $item)
        {
            SalesLog::create([
                'daily_log_id' => $dailyLog->id,
                'menu_item_id' => $item->id,
            ]);
        }
        return [['msg' => 'Daily Log is created successfully'],201];
    }
    public function DailyLogStatus($request){
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $workSpaceDailyLogs = $workSpace->dailyLogs;
        if($workSpaceDailyLogs->isEmpty())
        {
            $dailyLogStatus = DailyLogStatus::NO_DAILY_LOG_CAN_CREATE;
            return [[
                'dailyLogStatus' =>$dailyLogStatus,
            ],200];
        }        
        $request->validate(['created_at' => 'required|date']);
        $created_at = Carbon::create($request->created_at)->format('Y/m/d');
        $workSpaceDailyLogCreated_at = $workSpaceDailyLogs->last()->created_at;
        if ($workSpaceDailyLogCreated_at->format('Y/m/d') > $created_at){
            $dailyLogStatus = DailyLogStatus::NO_DAILY_LOG_CAN_NOT_CREATE;
            foreach ($workSpaceDailyLogs as $workSpaceDailyLog){
                if ($workSpaceDailyLog->created_at->format('Y/m/d') == $created_at){
                    $dailyLogStatus = DailyLogStatus::HAS_DAILY_LOG;
                    break;
                }
            }
        }
        else if ($workSpaceDailyLogCreated_at->format('Y/m/d') < $created_at){
            $dailyLogStatus = DailyLogStatus::NO_DAILY_LOG_CAN_CREATE;
        }
        else{
            $dailyLogStatus = DailyLogStatus::HAS_DAILY_LOG;
        }
        return [[
            'dailyLogStatus' =>$dailyLogStatus,
        ],200];
    }
}
