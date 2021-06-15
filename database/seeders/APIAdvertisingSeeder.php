<?php

namespace Database\Seeders;

use App\Models\Models\APIAdvertising;
use Illuminate\Database\Seeder;

class APIAdvertisingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Advertising = [];
        for ($i=0;$i<=1;$i++){
            for ($j=66;$j<=70;$j++){
                $Advertising[] = [
                    'city' => $j,
                    'icon' => 'https://yugid.ru/img/Mask_Group.png',
                    'a_href' => 'https://google.ru',
                ];
            }
        }
        APIAdvertising::query()->insert($Advertising);
    }
}
