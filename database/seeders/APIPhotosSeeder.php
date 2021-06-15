<?php

namespace Database\Seeders;

use App\Models\Models\APIPhotos;
use Illuminate\Database\Seeder;

class APIPhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photos = [];
        for ($i=551;$i<=825;$i++){
            for ($j=0; $j<=3; $j++){
                $photos[] = [
                    'publications'=>$i,
                    'link_img'=>'https://yugid.ru/ugid/image/phana-new6-min.jpg',
                ];
            }
        }
        APIPhotos::query()->insert($photos);
    }
}
