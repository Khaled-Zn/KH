<?php

namespace Modules\Log\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Log\Service\SalesLogService;

class SalesLogController extends Controller
{
    private SalesLogService $SalesLogService;
    public function __construct(SalesLogService $SalesLogService )
    {
        $this->SalesLogService = $SalesLogService;
    }
    public function show(Request $request) {
        $show = $this->SalesLogService->show($request);
        return response()->json($show[0],$show[1]);
    }
    public function add(Request $request) {
        $add = $this->SalesLogService->add($request);
        return response()->json($add[0],$add[1]);
    }
}
