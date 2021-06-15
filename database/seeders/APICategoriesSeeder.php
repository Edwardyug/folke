<?php

namespace Database\Seeders;

use App\Models\Models\APICategories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class APICategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];
        $category = ['Красота и здоровье','Кафе','Быстрое питание','Работа','Стоматология','Автосервис'
            ,'Эко-товары','Домашний мастер','Блошиный рынок','Транспортные перевозки','Отдам даром'
            ,'Ремонт ПК и телефонов','Аренда','Бухгалтер - юрист','Туризм','Продажа доменов','Недвижимость'
            ,'Знакомства','Другое'
        ];
        for ($i = 66; $i <= 70; $i++){
            for ($j = 0; $j <= 18; $j++){
                $categories[] = [
                    'city'=> $i,
                    'title'=>$category[$j],
                    'icon'=>'http://localhost/resources/img/categoriesicon/turis.png',
                    'slug'=>Str::slug($category[$j]),
                ];
            }
        }
        APICategories::query()->insert($categories);
    }
}
