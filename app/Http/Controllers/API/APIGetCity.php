<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\GeoCodingService;


class APIGetCity extends BaseController
{
    public function GetCity(Request $request){
        //Сделать валидацию
        $city = GeoCodingService::RequestCity($request['lat'],$request['lon']);
        $result =  [
            'contents' => $city,
        ];
        return collect($result)->toJson(JSON_UNESCAPED_UNICODE);
    }
}
