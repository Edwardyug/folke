<?php

namespace Database\Seeders;

use App\Models\Models\APILinkType;
use Illuminate\Database\Seeder;

class APILinksTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeLinks = [];
        for($i = 0; $i <= 2; $i++){
            $typeLinks[]=[
                'title' => 'VK',
                'icon' => 'icon.png'
            ];
        }
        APILinkType::query()->insert($typeLinks);
    }
}
