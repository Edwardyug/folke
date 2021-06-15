<?php

namespace Database\Seeders;

use App\Models\Models\APICity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class APICitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $cities = [];
      $city = ['Москва','Краснодар','Калининград','Геленджик','Ростов на дону','Пятигорск'];
      for ($i = 0; $i <= 4; $i++) {
          $cities[] = [
              'title' => $city[$i],
              'slug' => Str::slug($city[$i]),
          ];
      }
      APICity::query()->insert($cities);
    }
}
