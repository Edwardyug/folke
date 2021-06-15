<?php


namespace App\Repositories;


use App\Models\Models\APIPublications;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Models\APICategories;
use App\Models\Models\APIUnderCategories;

class APIPublicationRepository extends BaseRepository
{
    public function getAllmarkerFromcity($id){
        $result = APIPublications::where([['is_published','=','1'],['a_p_i_categories.city','=',$id]])
            ->join('a_p_i_categories','a_p_i_publications.category','=','a_p_i_categories.id')
            ->select('a_p_i_publications.id AS id','a_p_i_publications.category AS category','a_p_i_publications.title AS title'
                ,'a_p_i_publications.price AS price','a_p_i_publications.img_map AS img_map','lat','lon')
            ->get();
        return $result;
    }

    public function getAllPublicationFromUser($id){
        $result = APIPublications::where('user',$id)
            ->select('id','category','title','description','price','icon','is_published')
            ->get();
        return $result;
    }

    public function getSimilarPublication($categoryID){
        $publication = APIPublications::where([['a_p_i_categories.id',$categoryID],['a_p_i_publications.is_published', '=', 1]])
            ->join('a_p_i_categories','a_p_i_publications.category','=','a_p_i_categories.id')
            ->select('a_p_i_publications.id','a_p_i_publications.category','a_p_i_publications.title',
                'a_p_i_publications.description','a_p_i_publications.price','a_p_i_publications.icon',
                'a_p_i_publications.address','a_p_i_publications.is_published')
            ->limit(10)
            ->orderby('a_p_i_publications.id','DESC')
            ->get();
        $fmt = new \NumberFormatter( 'no_NO', \NumberFormatter::CURRENCY );
        foreach ($publication as $key) {
            $curr = $fmt->formatCurrency($key['price'], "NOK");
            $key['price'] = mb_substr($curr,0,mb_strlen($curr)-3);
            $key['description']=str_replace("\n", "", $key['description']);
        }
        return $publication;
    }

    public function getLastPublication($cityID, $count){
        $publication = APIPublications::where([['a_p_i_categories.city',$cityID],['a_p_i_publications.is_published', '=', 1]])
            ->join('a_p_i_categories','a_p_i_publications.category','=','a_p_i_categories.id')
            ->select('a_p_i_publications.id','a_p_i_publications.category','a_p_i_publications.title',
            'a_p_i_publications.description','a_p_i_publications.price','a_p_i_publications.icon',
            'a_p_i_publications.address','a_p_i_publications.is_published')
            ->limit($count)
            ->orderby('a_p_i_publications.id','DESC')
            ->get();
        $fmt = new \NumberFormatter( 'no_NO', \NumberFormatter::CURRENCY );
        foreach ($publication as $key) {
            $curr = $fmt->formatCurrency($key['price'], "NOK");
            $key['price'] = mb_substr($curr,0,mb_strlen($curr)-3);
            $key['description']=str_replace("\n", "", $key['description']);
        }
        return $publication;
    }

    public function getPaginateFromUnderCategory($id,$count){
        $paginate = APIPublications::where([['under_category',$id],['is_published', '=', 1]])
            ->select('id','category','title','description','price','icon')
            ->paginate($count);
        return $paginate;
    }

    public function getPaginateCategory($id,$count){
        $paginate = APIPublications::where([['category',$id],['is_published', '=', 1]])
            ->select('id','category','title','description','price','icon','address')
            ->paginate($count);
        $fmt = new \NumberFormatter( 'no_NO', \NumberFormatter::CURRENCY );
        foreach ($paginate as $key){
            $curr = $fmt->formatCurrency($key['price'], "NOK");
            $key['price'] = mb_substr($curr,0,mb_strlen($curr)-3);
            $key['description']=str_replace("\n", "", $key['description']);
        }
        return $paginate;
    }

    public function GetCategoryTitle($id){
        $Categories = APICategories::where('id',$id)
            ->select('title')
            ->get();
        return $Categories;
    }

    public function GetUnderCategoryTitle($id){
        $underCategories = APIUnderCategories::where('id',$id)
            ->select('title')
            ->get();
        return $underCategories;
    }

    public function GetUnderCategoryFormUndercategory($id){
        $Category = APIUnderCategories::where('id',$id)
            ->select('category')
            ->get();
        $UnderCategory = APIUnderCategories::where('category',$Category[0]['category'])
            ->select('id','title')
            ->get();
        return $UnderCategory;
    }

    public function GetUnderCategory($id) {
        $UnderCategory = APIUnderCategories::where('category',$id)
            ->select('id','title')
            ->get();
        return $UnderCategory;
    }

}
