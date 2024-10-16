<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Service\MenuService;

class MenuController extends Controller
{
    private MenuService $MenuService;
    public function __construct(MenuService $MenuService )
    {
        $this->MenuService = $MenuService;
    }
    public function Show($id = 0) {
        $Show = $this->MenuService->Show($id);
        return response()->json($Show[0],$Show[1]);
    }
}
