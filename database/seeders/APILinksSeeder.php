<?php

namespace Database\Seeders;

use App\Models\Models\APILinks;
use Illuminate\Database\Seeder;

class APILinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links=[];
        for ($i=0; $i<=18; $i++){
            $links[] = [
                'user' => rand(1,9),
                'type' => rand(1,3),
                'link' => 'www',
            ];
        }
        APILinks::query()->insert($links);
    }
}
