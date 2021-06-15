<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\APITemplates_properties_repository;
use Illuminate\Http\Request;

class templates_properties_controller extends Controller
{
    public function GetPropertiesFromUnderCategroy(Request $request,APITemplates_properties_repository $properties_repository){
        $properties = [
            'contents' => $properties_repository->GetPropertiesFromUndercategory($request['UnderCategroyName']),
        ];
        return response()->json($properties, 200);
       // return collect()->tojson(JSON_UNESCAPED_UNICODE);
    }
}
