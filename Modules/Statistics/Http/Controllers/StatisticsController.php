<?php

namespace Modules\Statistics\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Statistics\Service\StatisticsService;

class StatisticsController extends Controller
{

    public function show()
    {
        //$id = auth('admin-api')->user()->work_space_id;
        return response()->json((new StatisticsService)->handle(1));
    }

}
