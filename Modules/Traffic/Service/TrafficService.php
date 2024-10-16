<?php


namespace Modules\Traffic\Service;

use Exception;

class TrafficService
{

    public function GetTraffic()
    {
        $admin = auth()->user();
        $traffic = $admin->workSpace->traffic;
        if(!$traffic){
            throw new Exception('Work Space traffic is not found', 404);
        }
        return [$traffic->only('count','full'),200];
    }
}
