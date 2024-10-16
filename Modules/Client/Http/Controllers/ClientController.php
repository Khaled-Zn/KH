<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Service\ClientService;

class ClientController extends Controller
{
    private ClientService $ClientService;
    public function __construct(ClientService $ClientService )
    {
        $this->ClientService = $ClientService;
    }
    public function GetClient(Request $request) {
        $GetClient = $this->ClientService->GetClient($request);
        return response()->json($GetClient[0],$GetClient[1]);
    }
}
