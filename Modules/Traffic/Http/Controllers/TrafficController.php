<?php

namespace Modules\Traffic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Traffic\Service\TrafficService;

class TrafficController extends Controller
{
    private TrafficService $TrafficService;
    public function __construct(TrafficService $TrafficService )
    {
        $this->TrafficService = $TrafficService;
    }
    public function GetTraffic() {
        $GetTraffic = $this->TrafficService->GetTraffic();
        return response()->json($GetTraffic[0],$GetTraffic[1]);
    }
}
