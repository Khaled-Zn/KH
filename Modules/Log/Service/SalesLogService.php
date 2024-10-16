<?php


namespace Modules\Log\Service;
use Carbon\Carbon;
use Modules\Log\Models\SalesLog;
use Exception;

class SalesLogService
{
    public function show($request){

        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $request->validate(['created_at' => 'required|date']);
        $created_at = Carbon::create($request->created_at)->format('Y/m/d');
        foreach ($workSpace->dailyLogs as $dailyLog){
            if ($dailyLog->created_at->format('Y/m/d') == $created_at){
                return [$dailyLog->salesLog->load('menuItem'),200];
            }
        }
        return [[],200];

    }
    public function add($request){
        $request->validate([
            'sales_log_id' => 'required|integer',
            'created_at' => 'required|date'
        ]);
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        $workSpaceDailyLog = $workSpace->dailyLogs->last();
        $salesLog = SalesLog::find($request->sales_log_id);
        if (!$salesLog) throw new Exception('Sales Log is not found', 404);
        if ($salesLog->menuItem->menu->work_space_id != $admin->work_space_id) throw new Exception('this Menu Item is from another Work Space', 403);
        $created_at = Carbon::create($request->created_at)->format('Y/m/d');
        if ($workSpaceDailyLog->created_at->format('Y/m/d') > $created_at) throw new Exception('created at date is in the past', 409);
        else if ($workSpaceDailyLog->created_at->format('Y/m/d') < $created_at) throw new Exception('Daily Log is not created yet', 409);
        $salesLog->update(['counter' => ($salesLog->counter + 1)]);
        return [[
            'msg'=>'added'
        ],200];
    }
}
