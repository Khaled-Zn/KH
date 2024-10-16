<?php

namespace Modules\WorkSpace\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\WorkSpace\Models\WorkSpace;

class WorkSpaceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        WorkSpace::create([
            'name' => 'studyZone',
            'company_id' => 1
        ]);

        // $this->call("OthersTableSeeder");
    }
}
