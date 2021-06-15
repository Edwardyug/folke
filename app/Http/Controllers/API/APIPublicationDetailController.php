<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishRequest;
use App\Models\Models\APILinks;
use App\Models\Models\APIPhotos;
use App\Models\Models\APIPublicationProperties;
use App\Models\Models\APIPublications;
use App\Models\Models\APIUnderCategories;
use App\Models\Models\APIUsers;
use App\Repositories\APIPublicationDetailRepository;
use App\Repositories\APIPublicationRepository;
use Illuminate\Http\Request;
use App\Service\ImagickService;
use Illuminate\Support\Facades\Storage;
use function MongoDB\BSON\toJSON;

class APIPublicationDetailController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(Request $request,APIPublicationDetailRepository $APIPublicationDetailRepository)
    {
        $publicationDetail = $APIPublicationDetailRepository->GetDetailPublication($request['id']);
        return collect($publicationDetail)->toJson(JSON_UNESCAPED_UNICODE);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PublishRequest $request)
    {
        $hostname = 'https://folkeappen.no';

       // $hostname = 'http://192.168.0.100';

        $publishRepository = new APIPublicationDetailRepository;

         $inputData = $publishRepository->SetPublishData($request->input());
         $item = APIPublications::create($inputData);

         $MoveImagePath = public_path() . '/storage/'.\Auth::user()['id'].'/'.$item['slug'].'/';
         $LinkImage = '/storage/'.\Auth::user()['id'].'/'.$item['slug'].'/';

         if ($request->hasfile('image')) {
             $i = 0;
            foreach ($request->image as $file) {
                    $path = $file->storePublicly('public/'.\Auth::user()['id'].'/'.$item['slug']);
                    if ($i==0) {
                        $item['icon'] = $hostname.$LinkImage.ImagickService::CreateImageMain($MoveImagePath,basename($path)); //$LinkImage. $data[0];
                        $item['img_map'] = $hostname.$LinkImage.ImagickService::CreateImageMap($MoveImagePath,basename($path));
                    }
                    $i++;
                   // $data[] = ImagickService::CreatePhotosPublic($MoveImagePath,basename($path));
                    $img_links[] =
                        APIPhotos::create([
                            'publications' => $item->id,
                            'link_img'=>$hostname.$LinkImage.basename($path),
                        ]);
            }
        }
         if (count($request->PropertyArray)>0){
            foreach ($request->PropertyArray as $key => $value){
                APIPublicationProperties::create([
                    'title'=>$key,
                    'text'=>$value,
                    'publicationID'=>$item->id,
                ]);
            }
         }

       $item->save();
            return response()->json([
                'messag' => 'ok',
            ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return string
     */
    public function edit(Request $request)
    {
        $publishRepository = new APIPublicationDetailRepository;
        $publication = $publishRepository->GetPublicationForEdit($request['id']);
        return collect($publication)->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $publishRepository = new APIPublicationDetailRepository;

        $hostname = 'https://folkeappen.no';
       // $hostname = 'http://192.168.0.100';
        $userID = \Auth::user()['id'];
        if ($publishRepository->PublishBelongsUser($userID,$request['id'])){
            $publication = APIPublications::find($request['id']);
            $dataPublication = $publishRepository->SetUpdateData($request->all());
            $Photo = APIPhotos::where('publications',$request['id'])->delete();
            $MoveImagePath = public_path() . '/storage/'.\Auth::user()['id'].'/'.$publication['slug'].'/';
            $LinkImage = '/storage/'.\Auth::user()['id'].'/'.$publication['slug'].'/';
            if ($request->hasfile('image')) {
                foreach ($request->image as $file) {
                    $name = $file->getClientOriginalName();
                    $md5Name = uniqid().$name;
                    $path = $file->storePublicly('public/'.\Auth::user()['id'].'/'.$publication['slug'].'/');
                  //  $data[] = ImagickService::CreatePhotosPublic($MoveImagePath,basename($path));
                    //$data[] = $path;
                    $img_links[] =
                        APIPhotos::create([
                            'publications' => $publication['id'],
                            'link_img'=>$hostname.$LinkImage.basename($path),
                        ]);
                }
                $publication['icon'] = $hostname.$LinkImage.ImagickService::CreateImageMain($MoveImagePath,basename($data[0])); //$LinkImage. $data[0];
                $publication['img_map'] = $hostname.$LinkImage.ImagickService::CreateImageMap($MoveImagePath,basename($data[0]));
            }
        } else {
            return response()->json([
                'messag' => 'Publish is not belongs this user or not found',
            ], 200);
        }

        $result = $publication->fill($dataPublication)->save();
        if ($result){
            return response()->json([
                'messag' => 'ok',
            ], 200);
        } else {
            return response()->json([
                'messag' => 'error',
            ], 200);
        }
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
