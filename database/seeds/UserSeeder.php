<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Goal;
use App\Models\Target;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
        Goal::truncate();
        Target::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

        $faker = Faker::create('ja_JP');

        for($i = 0; $i < 10; $i++){
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('testtest')
            ]);
        }
    }
}
