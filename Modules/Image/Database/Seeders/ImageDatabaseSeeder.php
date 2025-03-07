<?php

namespace Modules\Image\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ImageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $types = [
            ['name' => 'main'],
            ['name' => 'gallery']
        ];  
        DB::table('type_images')->insert($types);
        // $this->call("OthersTableSeeder");
    }
}
