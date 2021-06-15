<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Models\APIUnderCategories;
use App\Repositories\APIPublicationRepository;
use Illuminate\Http\Request;

class APIUnderCategoryController extends BaseController
{

    public  function deleteUnderCategory(Request $request){
        APIUnderCategories::find($request['id'])->delete();
        return response()->json([
            'messag' => 'ok',
        ], 200);
    }

    public function GetUnderCategory(Request $request, APIPublicationRepository $APIPublicationRepository){
        $Result= [
            'contents'=>$APIPublicationRepository->GetUnderCategory($request['undercategory']),
             ];

        return collect($Result)->tojson(JSON_UNESCAPED_UNICODE);

    }

    public function AddUnderCategory(Request $request){
        $inputData = [
            'title'=>$request['title'],
            'category'=>$request['categoryid'],
        ];
        $item = new APIUnderCategories($inputData);
        if ($item->save()) {
            return response()->json([
                'messag' => 'ok',
            ], 200);
        }
    }

}
