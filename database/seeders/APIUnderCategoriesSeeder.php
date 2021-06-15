<?php

namespace Database\Seeders;

use App\Models\Models\APIUnderCategories;
use Faker\Factory;
use Illuminate\Database\Seeder;

class APIUnderCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $undercategory = [];
        $undercategories = ['Часы', 'Телефоны','Компьютеры','Растения','Книги'];
        $faker = Factory::create();
        for ($i = 287; $i<=311;$i++) {
            for ($j=0; $j<=4; $j++) {
                $undercategory[] = [
                   'category'=>$i,
                   'title'=>$undercategories[$j],
                ];
            }
        }
        APIUnderCategories::query()->insert($undercategory);
    }
}
