<?php
namespace Modules\Statistics\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class StatisticsService {

    private $unregistered = 'Unregistered';
    private $user = 'User';
    public function handle($id) {

        $clients = $this->getClients($id);
        $statisticsOnCity = $this->statisticsOnCity($clients);
        $statisticsOnTalent = $this->statisticsOnTalent($clients);
        $averageNumberOfAgeClients = $this->averageNumberOfAgeClients($clients);
        $averageNumberOfClientsPerDay = $this->averageNumberOfClientsPerDay($id);
        $averageNumberOfSalesPerDay = $this->averageNumberOfSalesPerDay($id);
        return [
            'statisticsOnCity' => $statisticsOnCity->original,
            'statisticsOnTalent' => $statisticsOnTalent->original,
            'averageNumberOfAgeClients' => $averageNumberOfAgeClients,
            'averageNumberOfClientsPerDay' => $averageNumberOfClientsPerDay,
            'averageNumberOfSalesPerDay' => $averageNumberOfSalesPerDay
        ];

    }
    public function statisticsOnCity($clients) {
        
        $unregisteredIds = $clients[$this->unregistered]->pluck('clientable_id');
        $unregistereds = $this->clientsQuery($this->unregistered,$unregisteredIds,['residences','rs']);
        $userIds = $clients[$this->user]->pluck('clientable_id');
        $users = $this->clientsQuery($this->user,$userIds,['residences','rs']);
        $allUsers = $users->merge($unregistereds)->groupBy('residence');
        $statisticsOnCity = $allUsers->map(function($item,$key){
            return $item->sum('userCount');
        });
        return response()->json($statisticsOnCity);
    }
    public function statisticsOnTalent($clients) {

        $unregisteredIds = $clients[$this->unregistered]->pluck('clientable_id');
        $unregisteredTalentCount = $this->talentQuery($unregisteredIds,Str::lcfirst($this->unregistered));
        $userIds = $clients[$this->user]->pluck('clientable_id');
        $userTalentCount = $this->talentQuery($userIds,Str::lcfirst($this->user));
        $allUsers = $userTalentCount->merge($unregisteredTalentCount)->groupBy('talent');
        $statisticsOnTalent = $allUsers->map(function($item,$key){
            return $item->sum('userCount');
        });
        return response()->json($statisticsOnTalent);
    } 

    public function averageNumberOfAgeClients($clients) {
        $unregisteredsAges = DB::table('unregistereds')->whereIn('id',$clients[$this->unregistered]->pluck('clientable_id'))
        ->get(['age']);
        foreach($unregisteredsAges as $age) {
            $age->age = Carbon::parse($age->age)->age;
        }
        $usersAges = DB::table('users')->whereIn('id',$clients[$this->user]->pluck('clientable_id'))
        ->get(['age']);
        foreach($usersAges as $age) {
            $age->age = Carbon::parse($age->age)->age;
        }
        $allUsers = $usersAges->merge($unregisteredsAges);
        $allUsers = $allUsers->average(function($user){
            return $user->age;
        });
        return floor($allUsers);
    }

    public function averageNumberOfClientsPerDay($id) {
        $tables  = ['daily_logs','logs'];
        return $this->calculateAverage($tables,$id);
    }
    public function averageNumberOfSalesPerDay($id) {
        $tables  = ['daily_logs','sales_logs'];
        return $this->calculateAverage($tables,$id);
    }
    private function calculateAverage($tables,$id) {
        $logIds = DB::table($tables[0])->where('work_space_id',$id)
        ->pluck('id');
        $countClients = DB::table($tables[1])->whereIn("daily_log_id",$logIds)
        ->select(DB::raw('count(*) as userCount'))
        ->groupBy("daily_log_id")->get();
        
        $average = $countClients->sum('userCount') / count($logIds);
        return $average;
    }


    private function getClients($id) {
        $clients = DB::table('clients')->where('work_space_id',$id)
        ->select(['clientable_type','clientable_id'])->get();
        foreach($clients as $client) {
            $client->type = Str::afterLast($client->clientable_type, '\\');
            unset($client->clientable_type);
        }
        return collect($clients)->groupBy('type');
    }
    private function talentQuery($ids,$typeClient) {
        return DB::table("talent_{$typeClient} as td")->whereIn("{$typeClient}_id",$ids)
        ->join("talents as tt",'td.talent_id','=',"tt.id")
        ->select(DB::raw("count(*) as userCount,tt.talent"))
        ->groupBy('tt.talent')
        ->get();
    }
    private function clientsQuery($typeClients,$ids,$table) {

        return DB::table(Str::lcfirst($typeClients)  . 's as us')
        ->select(DB::raw("count(*) as userCount,{$table[1]}.residence"))
        ->whereIn('us.id',$ids)->join("{$table[0]} as {$table[1]}",'us.residence_id','=',"{$table[1]}.id")
        ->groupBy("{$table[1]}.residence")
        ->get();
    } 
}
