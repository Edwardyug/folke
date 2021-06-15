<?php

namespace App\Repositories;

use App\Models\Models\APIAdvertising;
use App\Models\Models\APICategories;


class APICategoriesRepository extends BaseRepository
{
    public function getCategoriesView($id) {
        $Categories = APICategories::where('city',$id)
            ->select('id','title','icon')
            ->get();
        //   $Advertising = APIAdvertising::where('city',$id)
        //   ->select('icon','a_href')
       //    ->get();
       // return  [
      //      'Categories' => $Categories,
     //       'Advertising' =>$Advertising,
    //    ];
        return $Categories;
    }
}
