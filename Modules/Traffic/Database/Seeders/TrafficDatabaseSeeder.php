<?php

namespace Modules\Traffic\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Traffic\Models\Traffic;

class TrafficDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Traffic::create([
            'work_space_id' => 1,
            'count' => 100,
            'full' => 200
        ]);

        // $this->call("OthersTableSeeder");
    }
}
