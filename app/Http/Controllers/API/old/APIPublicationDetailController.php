<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishRequest;
use App\Models\Models\APILinks;
use App\Models\Models\APIPhotos;
use App\Models\Models\APIPublications;
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
            foreach ($request->image as $file) {
                    $name = $file->getClientOriginalName();
                    $md5Name = uniqid().$name;
                    $path = $file->storePublicly('public/'.\Auth::user()['id'].'/'.$item['slug'].'/');
                    $data[] = $path;
                    $img_links[] =
                        APIPhotos::create([
                            'publications' => $item->id,
                            'link_img'=>$hostname.$LinkImage.basename($path),
                        ]);
            }
            $item['icon'] = $hostname.$LinkImage.ImagickService::CreateImageMain($MoveImagePath,basename($data[0])); //$LinkImage. $data[0];
            $item['img_map'] = $hostname.$LinkImage.ImagickService::CreateImageMap($MoveImagePath,basename($data[0]));
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
