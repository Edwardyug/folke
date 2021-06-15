<?php


namespace App\Repositories;


use App\Models\Models\APILinks;
use App\Models\Models\APIPhotos;
use App\Models\Models\APIPublicationProperties;
use App\Models\Models\APIPublications;
use App\Models\Models\APIUnderCategories;
use App\Service\GeoCodingService;
use Illuminate\Support\Carbon;
use mysql_xdevapi\Result;
use Str;

class APIPublicationDetailRepository extends BaseRepository
{

    public function PublishBelongsUser($userID,$publishID){
      $item = APIPublications::where([['id',$publishID],['user',$userID]])
      ->get();
      if ($item->count()>0){
          return true;
      } else {
          return false;
      }
    }

    public function SetUpdateData($Data){
        $coord = GeoCodingService::GetCoordinate($Data['address']);
        $Category_id = APIPublications::where('id',$Data['id'])
            ->select('category')
            ->get();
        $under_categoriesID = APIUnderCategories::where([['category','=',$Category_id[0]['category']],['title','=',$Data['under_category']]])
            ->select('id')
            ->get();
        return [
            'title' => $Data['title'],
            'description'=>$Data['description'],
            'price'=>$Data['price'],
            'address'=>$Data['address'],
            'under_category'=>$under_categoriesID[0]['id'],
            'lat' =>$coord['lat'],
            'lon' =>$coord['lon'],
        ];
    }

    public function SetPublishData($Data){
        $coord = GeoCodingService::GetCoordinate($Data['address']);
        $under_categoriesID = APIUnderCategories::where([['category','=',$Data['category']],['title','=',$Data['under_category']]])
            ->select('id')
            ->get();
        return [
            'category'=>$Data['category'],
            'title' =>$Data['title'],
            'description'=>$Data['description'],
            'price'=>$Data['price'],
            'icon'=>'',
            'img_map'=>'',
            'address'=>$Data['address'],
            'lat' =>$coord['lat'],
            'lon' =>$coord['lon'],
            'slug' => Str::slug($Data['title']).uniqid(),
            'user'=>\Auth::user()['id'],
            'under_category'=>$under_categoriesID[0]['id'],
            'is_published' => 1,
            'publish_at'=> Carbon::now(),
            'stop_publish_at'=>  Carbon::now()->addMonth(),
        ];
    }

    public function GetPublicationForEdit($id){
        $publication = APIPublications::where('a_p_i_publications.id', $id)
            ->join('a_p_i_under_categories','a_p_i_publications.under_category','=','a_p_i_under_categories.id')
            ->select('a_p_i_publications.id','a_p_i_publications.title','a_p_i_publications.category','a_p_i_publications.description'
                ,'a_p_i_publications.price','a_p_i_publications.address','a_p_i_under_categories.title AS undercategory_title')
            ->get();
        $photo = APIPhotos::where('publications', $id)
            ->select('link_img')
            ->get();
        $undercategories = APIUnderCategories::where('category',$publication[0]['category'])
            ->select('title')
            ->get();
        return $result = [
            'publication' => $publication,
            'photo' => $photo,
            'undercategories' => $undercategories,
        ];
    }

    public function GetDetailPublication($id){
        $similarpublication = new APIPublicationRepository;
        $publication = APIPublications::where([['a_p_i_publications.id', $id], ['a_p_i_publications.is_published', '=', 1]])
            ->join('a_p_i_categories','a_p_i_publications.category','=','a_p_i_categories.id')
            ->join('a_p_i_under_categories','a_p_i_publications.under_category','=','a_p_i_under_categories.id')
            ->join('users','a_p_i_publications.user','=','users.id')
            ->select('a_p_i_publications.price AS price','a_p_i_publications.title AS PublicaTionstitle','a_p_i_publications.category',
                'a_p_i_publications.description','a_p_i_categories.title AS CategoriesTitle',
                'a_p_i_under_categories.title AS UnderCategoriesTitle', 'users.phone',
                'users.id AS user','a_p_i_under_categories.id AS UnderCategoriesid','a_p_i_publications.address AS address')
            ->get();
        //echo $publication;
        if (collect($publication)->isNotEmpty()) {
            $fmt = new \NumberFormatter( 'no_NO', \NumberFormatter::CURRENCY );

            foreach ($publication as $key) {
                $categoryId = $key['category'];
                $userid = $key['user'];
                $curr = $fmt->formatCurrency($key['price'], "NOK");
                $key['price'] = mb_substr($curr,0,mb_strlen($curr)-3);
                $key['description']=str_replace("\n", "", $key['description']);
            }
            $photo = APIPhotos::where('publications', $id)
                ->select('link_img')
                ->get();
            $links = APILinks::where('a_p_i_links.user', $userid)
                ->join('a_p_i_link_types', 'a_p_i_links.type', '=', 'a_p_i_link_types.id')
                ->select('a_p_i_links.link', 'a_p_i_link_types.icon')
                ->get();
            $Properties = APIPublicationProperties::where('publicationID',$id)
                ->select('id','title','text')
                ->get();
            $similar = $similarpublication->getSimilarPublication($categoryId);
            $PublicationDetail = [
                'Publication' => $publication,
                'Photos' => $photo,
                'Links' => $links,
                'prop'=>$Properties,
                'similar'=>$similar,
            ];

            return $PublicationDetail;
        } else return ['message'=>'not found publication'];
    }

}
