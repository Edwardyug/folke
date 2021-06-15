<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Models\APIPublications;
use App\Repositories\APICategoriesRepository;
use App\Repositories\APIPublicationRepository;
use Illuminate\Http\Request;
use App\Repositories\APIAdvertisingRepository;
class APIPublicationsListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,  APIPublicationRepository $APIPublicationRepository,APIAdvertisingRepository $APIAdvertisingRepository)
    {
        if (isset($request['undercategory'])){
            $paginator = $APIPublicationRepository->getPaginateFromUnderCategory($request['undercategory'],10);
            $title = $APIPublicationRepository->GetUnderCategoryTitle($request['undercategory'])[0]['title'];
            $underCategory = $APIPublicationRepository->GetUnderCategoryFormUndercategory($request['undercategory']);
            $advertisings = $APIAdvertisingRepository->GetAdvertisingFromUnderCategory($request['undercategory']);

        } else
        {
            $paginator = $APIPublicationRepository->getPaginateCategory($request['id'],10);
            $title = $APIPublicationRepository->GetCategoryTitle($request['id'])[0]['title'];
            $underCategory = $APIPublicationRepository->GetUnderCategory($request['id']);
            $advertisings = $APIAdvertisingRepository->GetAdvertisingFromCategory($request['id']);
        }
        $collectPAginator = collect($paginator);
        foreach ($collectPAginator['links'] as $key){
            $links[] = [
              'url' => $key['url'],
              'title' => strval($key['label']),
              'active' => $key['active']
            ];
        }

        $collectPAginator['links'] = $links;

        $result = collect([
            'contents' => $collectPAginator,
            'title' => $title,
            'UnderCategories' => $underCategory,
            'advertisings'=>$advertisings,
        ]);
        return $result->toJson(JSON_UNESCAPED_UNICODE);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
