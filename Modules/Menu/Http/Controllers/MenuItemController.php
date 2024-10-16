<?php

namespace Modules\Menu\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Service\MenuItemService;

class MenuItemController extends Controller
{
    private MenuItemService $MenuItemService;
    public function __construct(MenuItemService $MenuItemService )
    {
        $this->MenuItemService = $MenuItemService;
    }
    public function create(Request $request)
    {
        $create = $this->MenuItemService->create($request);
        return response()->json($create[0],$create[1]);
    }
    public function update(Request $request)
    {
        $update = $this->MenuItemService->update($request);
        return response()->json($update[0],$update[1]);
    }
    public function destroy($id)
    {
        $destroy = $this->MenuItemService->destroy($id);
        return response()->json($destroy[0],$destroy[1]);
    }
}
