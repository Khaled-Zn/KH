<?php

namespace Modules\Unregistered\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Unregistered\Service\UnregisteredCompleteInfoService;

class UnregisteredController extends Controller
{
    private UnregisteredCompleteInfoService $UnregisteredCompleteInfoService;
    public function __construct(UnregisteredCompleteInfoService $UnregisteredCompleteInfoService )
    {
        $this->UnregisteredCompleteInfoService = $UnregisteredCompleteInfoService;
    }
    public function CompleteInfo(Request $request) {
        $CompleteInfo = $this->UnregisteredCompleteInfoService->CompleteInfo($request);
        return response()->json($CompleteInfo[0], $CompleteInfo[1]);
    }
}
