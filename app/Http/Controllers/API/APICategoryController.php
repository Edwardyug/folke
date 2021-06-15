<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Models\APIAdvertising;
use App\Models\Models\APICategories;
use App\Models\Models\APICity;
use App\Repositories\APIAdvertisingRepository;
use App\Repositories\APICategoriesRepository;
use App\Repositories\APIPublicationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class APICategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, APICategoriesRepository $categoriesRepository,
                          APIPublicationRepository $publication, APIAdvertisingRepository $advertisingRepository)
    {
        $CategoriesView = $categoriesRepository->getCategoriesView($request['city']);
        $LastPublication = $publication->getLastPublication($request['city'],20);
        $advertising = $advertisingRepository->GetAdvertisingFromCity($request['city']);
        $result = [
            'contents'=>$CategoriesView,
            'lastPublication' => $LastPublication,
            'advertising' => $advertising,
        ];
        return collect($result)->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $inputData = [
            'title'=>$request['title'],
            'icon'=>$request['icon'],
            'slug'=>Str::slug($request['title']),
            'city'=>$request['city'],
        ];
        $item = new APICategories($inputData);
        if ($item->save()) {
            return response()->json([
                'messag' => 'ok',
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(__METHOD__);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd(__METHOD__);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        APICategories::find($id)->delete();
            return response()->json([
                'messag' => 'ok',
            ], 200);
    }
}
