<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\APIPublicationRepository;
use Illuminate\Http\Request;

class APIMapMarkerController extends BaseController
{
    public function GetAllMapMarkerFromCity(Request $request, APIPublicationRepository $APIPublicationRepository)
    {
        $v = \Validator::make($request->all(), [
            'id' => 'required|numeric|min:0|not_in:0',
        ]);
        if ($v->validated()) {
            $markers = [
                'contents' => $APIPublicationRepository->getAllmarkerFromcity($request['id']),
            ];
        } else {
            $markers = [
                'contents' => 'error',
            ];
        }
        return collect($markers)->toJson(JSON_UNESCAPED_UNICODE);
    }
}
