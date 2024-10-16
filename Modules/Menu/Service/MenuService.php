<?php


namespace Modules\Menu\Service;


use Carbon\Carbon;
use Modules\Menu\Models\Menu;
use Exception;
use Modules\WorkSpace\Models\WorkSpace;

class MenuService
{
    public function Show($id){
        if($id == 0)
        {
            $admin = auth('admin-api')->user();
            $workSpace = $admin->workSpace;
        } else {
            $workSpace = WorkSpace::find($id);
        }
        if(!$workSpace){
            throw new Exception('no work space is found',404);
        }
        $menu = $workSpace->menu;
        if(!$menu){
            throw new Exception('no menu is found',404);
        }
        return [$menu->menuItems,200];
    }
}
