<?php

namespace Database\Seeders;

use App\Models\Models\APIUsers;
use Faker\Factory;
use Illuminate\Database\Seeder;

class APIUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [];
        $faker = Factory::create();
        for ($i=2;$i<=9;$i++){
            $user[] = [
                'first_name'=>$faker->name,
                'last_name'=>$faker->lastName,
                'phone'=>$faker->phoneNumber,
                'email'=>$faker->email,
                'password'=>$faker->password,
            ];
        }
        APIUsers::query()->insert($user);
    }
}
