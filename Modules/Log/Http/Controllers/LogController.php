<?php

namespace Modules\Log\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Log\Service\LogService;

class LogController extends Controller
{
    private LogService $LogService;
    public function __construct(LogService $LogService )
    {
        $this->LogService = $LogService;
    }
    public function CreateLog(Request $request) {
        $CreateLog = $this->LogService->CreateLog($request);
        return response()->json($CreateLog[0],$CreateLog[1]);
    }
    public function FindUserByNumber(Request $request) {
        $FindUserByNumber = $this->LogService->FindUserByNumber($request);
        return response()->json($FindUserByNumber[0],$FindUserByNumber[1]);
    }
    public function DeleteLog() {
        $DeleteLog = $this->LogService->DeleteLog();
        return response()->json($DeleteLog[0],$DeleteLog[1]);
    }
    public function ShowLogs(Request $request) {
        $ShowLogs = $this->LogService->ShowLogs($request);
        return response()->json($ShowLogs[0],$ShowLogs[1]);
    }
}
