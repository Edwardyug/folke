<?php

namespace App\Http\Controllers\API;

use App\Models\Models\APICity;
use App\Repositories\APICityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class APICityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(APICityRepository $cityRepository)
    {
        $cities = $cityRepository->getCityShow();
        return collect($cities)->toJson(JSON_UNESCAPED_UNICODE);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title'=>$request['city'],
            'slug'=>Str::slug($request['city']),
        ];
        $item = new APICity($inputData);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        APICity::find($request['id'])->delete();
        return response()->json([
            'messag' => 'ok',
        ], 200);
    }
}
