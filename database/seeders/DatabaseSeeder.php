<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Modules\Shared\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Unregistered\Models\Unregistered;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $a = 0;
        User::truncate();
        Unregistered::truncate();
        DB::table('talent_user')->truncate();
        DB::table('talent_unregistered')->truncate();
        DB::table('talents')->truncate();
        DB::table('residences')->truncate();
        DB::table('specialities')->truncate();
        $sp = [
            'IT',
            'Doctor',
            'Pharmacist',
            'Dentist',
            'Architecture',
            'Civil',
            'Mechanic',
            'Scientist',
            'Finance',
            'Lawyer'
        ];
        $tal = [
            'Music',
            'Art',
            'Dance',
            'Act',
            'Pottery',
            'Reading',
            'Sport',
            'Cooking',
            'Technology',
            'Chess'
        ];
        $re = [
            'garamana',
            'mazraa',
            'babtoma',
            'sahnaya',
            'Souq Saroujah',
            'Old City',
            'midan',
            'mezzeh',
            'tabblah',
            'hijaz'
        ];
        for ($i=0; $i <count($sp) ; $i++) { 
            DB::table('specialities')->insert([
             'speciality' => $sp[$i],
            ]);
            DB::table('talents')->insert([
                'talent' => $tal[$i],
               ]);
               DB::table('residences')->insert([
                'residence' => $re[$i],
               ]);
        }
        while ($a <= 30) {
            
           $user =  User::create([
                'username' => $faker->unique()->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'email_verification_token' => Str::random(10),
                'password' => Hash::make('password'),
                'number' => '09' . $faker->randomNumber(8),
                'full_name' => $faker->name() . ' ' . $faker->name(),
                'age' => $faker->dateTimeBetween($startDate = '-22 years', $endDate = 'now', $timezone = null) ,
                'residence_id' => $faker->numberBetween($min = 1, $max = 10),
                'study_id' => $faker->numberBetween($min = 1, $max = 10),
                'study_type' => 'Modules\CompleteInfo\Models\Speciality'
            ]);
           for ($i=0; $i <3 ; $i++) { 
               DB::table('talent_user')->insert([
                'user_id' => $user->id,
                'talent_id' => $faker->numberBetween($min = 1, $max = 10),
               ]);
           }
           $un =  Unregistered::create([
                'username' => $faker->unique()->name(),
                'email' => $faker->unique()->safeEmail(),
                'number' => '09' . $faker->randomNumber(8),
                'full_name' => $faker->name() . ' ' . $faker->name(),
                'age' => $faker->dateTimeBetween($startDate = '-22 years', $endDate = 'now', $timezone = null) ,
                'residence_id' => $faker->numberBetween($min = 1, $max = 10),
                'study_id' => $faker->numberBetween($min = 1, $max = 10),
                'study_type' => 'Modules\CompleteInfo\Models\Speciality'
            ]);
            for ($i=0; $i <3 ; $i++) { 
                DB::table('talent_unregistered')->insert([
                 'unregistered_id' => $un->id,
                 'talent_id' => $faker->numberBetween($min = 1, $max = 10),
                ]);
            }
            $a++;   
        }

    }
}
