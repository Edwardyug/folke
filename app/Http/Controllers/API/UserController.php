<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Models\APILinks;
use App\Models\Models\APILinkType;
use App\Models\Models\APIUsers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\APIPublicationRepository;

class UserController extends BaseController
{

    public function ChekURL($url){
        if (preg_match('|^https*://|', $url) === 0)
        {
            $url = 'http://' . $url;
        }
        return $url;
    }

    public function GetLinkType($link){
        $linktype = APILinkType::where('title',$link)
            ->select('id')
            ->get();
        if ($linktype->isEmpty()) {
            return 0;
        } else {
            return $linktype[0]['id'];
        }
    }

    public function UpdateUser(Request $request){
         $userID = \Auth::user()['id'];
         $user = User::find($userID);
         $dataUser = $request->all();
         $links = APILinks::where('user',$userID)->delete();
          if (!empty($dataUser['links'])){
          foreach ($dataUser['links'] as $link) {
              $url = self::ChekURL($link);
              $data = [
                  'user' => $userID,
                  'link' => $url,
                  'type' => self::GetLinkType(parse_url($url, PHP_URL_HOST)),
              ];
              APILinks::create($data);
          }
      }

          $result = $user->fill($dataUser)->save();
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

    public function GetUserInfo(APIPublicationRepository $APIPublicationRepository){

        $userID = \Auth::user()['id'];
        $links = APILinks::where('user',$userID)
            ->join('a_p_i_link_types','a_p_i_links.type','=','a_p_i_link_types.id')
            ->select('a_p_i_links.id AS id','a_p_i_links.link AS Link','a_p_i_link_types.icon AS icon')
            ->get();
        $publication = $APIPublicationRepository->getAllPublicationFromUser($userID);

        $result = [
            'first_name' => \Auth::user()['name'],
            'last_name' => \Auth::user()['last_name'],
            'phone' => \Auth::user()['phone'],
            'email' => \Auth::user()['email'],
            'photo' => \Auth::user()['photo'],
            'links' => $links,
            'publication' => $publication,
        ];
        return response()->json($result);
    }
}
