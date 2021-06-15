<?php

namespace App\Repositories;

use App\Models\Models\APICity;

class APICityRepository extends BaseRepository
{


    public function getCityShow() {
       // $Cities = APICity::all('id','title');
        $Cities = APICity::orderBy('title')->select('id','title')->get();
       // $grouped = $Cities->groupBy(function ($item, $key) {
        //    return substr($item->title, 0, 1);
      //  });

        return  [
            'contents' => $Cities,
        ];
    }
}
