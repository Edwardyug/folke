<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Models\templates_categories;
use Illuminate\Http\Request;

class APItemplatesCategoryController extends BaseController
{
    public function GetAllCategory(){
        $item = [
            'contents'=> templates_categories::all(),
        ];
        return collect($item)->toJson(JSON_UNESCAPED_UNICODE);
    }
}
