<?php


namespace Modules\Menu\Service;

use Exception;
use Modules\Log\Models\SalesLog;
use Modules\Menu\Models\MenuItem;

class MenuItemService
{
    public function create($request)
    {
        $request->validate([
            'price'=> 'required|integer',
            'name' => 'required|string'
        ]);
        $admin = auth()->user();
        $workSpace = $admin->workSpace;
        if(!$workSpace){
            throw new Exception('no work space is found',404);
        }
        $menu = $workSpace->menu;
        if(!$menu){
            throw new Exception('no menu is found',404);
        }
        $menuItem = MenuItem::create([
            'menu_id' => $menu->id,
            'price'=> $request->price,
            'name' => $request->name
        ]);
        $dailyLogs = $workSpace->dailyLogs;
        if($dailyLogs->isEmpty()){
            throw new Exception('no daily Log is found',404);
        }
        $dailyLog = $dailyLogs->last();
        SalesLog::create([
            'daily_log_id' => $dailyLog->id,
            'menu_item_id' => $menuItem->id,
        ]);
        return [$menuItem,200];
    }
    public function update($request)
    {
        $request->validate([
            'menu_item_id'=>'required|',
            'price'=> 'required|integer',
            'name' => 'required|string'
        ]);
        $admin = auth()->user();
        $menuItem = MenuItem::find($request->menu_item_id);
        if (!$menuItem)
            throw new Exception('this item is not found',404);
        if ($admin->work_space_id != $menuItem->menu->work_space_id)
            throw new Exception('this item is not for this Work Space',403);
        $menuItem->price = $request->price;
        $menuItem->name = $request->name;
        $menuItem->save();
        return [$menuItem,200];
    }
    public function destroy($id)
    {
        $admin = auth()->user();
        $menuItem = MenuItem::find($id);
        if (!$menuItem)
            throw new Exception('this item is not found',404);
        if ($admin->work_space_id != $menuItem->menu->work_space_id)
            throw new Exception('this item is not for this Work Space',403);
        $menuItem->delete();
        return [['msg'=>'Item is deleted successfully'],200];
    }
}
