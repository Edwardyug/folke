<?php

namespace Database\Seeders;

use App\Models\Models\APIPublications;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class APIPublicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publication = [];
        $faker = Factory::create();
        $mytime = \Illuminate\Support\Carbon::now();
        for ($i=287;$i<=311;$i++){
            for ($j=0;$j<=10;$j++){
                $publication[] = [
                 'category'=>$i,
                 'title'=>'Объявление '.$i,
                 'description'=>'Описание объявления',
                 'price'=>7*$i,
                 'icon'=>'http://192.168.0.100/storage/3/werwerew606ad030c4661/photo_main.jpg',
                 'slug'=>Str::slug('объявление '.uniqid()),
                 'user'=>rand(1,9),
                 'under_category'=>rand(401,525),
                 'publish_at'=>$mytime,
                 'stop_publish_at'=>$faker->dateTime('+2 months','-1 days'),
                 'is_published'=>rand(0,1),
                 'address'=>'Åkersvebakken 9, 2830 Raufoss, Norge',
                 'lat'=>'1',
                 'lon'=>'1',
                 'img_map'=> 'http://192.168.0.100/storage/3/werwerew606ad030c4661/photo_map.png',
                ];
            }
        }
        APIPublications::query()->insert($publication);
    }
}
