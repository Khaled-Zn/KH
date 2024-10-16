<?php

namespace Modules\Log\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Log\Service\DailyLogService;

class DailyLogController extends Controller
{
    private DailyLogService $DailyLogService;
    public function __construct(DailyLogService $DailyLogService )
    {
        $this->DailyLogService = $DailyLogService;
    }
    public function CreateDailyLog(Request $request) {
        $CreateDailyLog = $this->DailyLogService->CreateDailyLog($request);
        return response()->json($CreateDailyLog[0],$CreateDailyLog[1]);
    }
    public function DailyLogStatus(Request $request) {
        $DailyLogStatus = $this->DailyLogService->DailyLogStatus($request);
        return response()->json($DailyLogStatus[0],$DailyLogStatus[1]);
    }
}
