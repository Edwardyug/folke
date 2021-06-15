<?php


namespace App\Repositories;
use App\Models\Models\APIAdvertising;


class APIAdvertisingRepository extends BaseRepository
{
    public function GetAdvertisingFromCity($id){
        return APIAdvertising::where('city',$id)
            ->select('id','icon','a_href','title','description','detail')
            ->get();
    }

    public function GetAdvertisingFromCategory($id){
        return APIAdvertising::where('a_p_i_categories.id', '=', $id)
            ->join('a_p_i_cities','a_p_i_advertisings.city','=','a_p_i_cities.id')
            ->join('a_p_i_categories','a_p_i_categories.city','=','a_p_i_cities.id')
            ->select('a_p_i_advertisings.id AS id','a_p_i_advertisings.icon AS icon','a_p_i_advertisings.a_href AS a_href')
            ->get();
    }

    public function GetAdvertisingFromUnderCategory($id){
        return APIAdvertising::where('a_p_i_under_categories.id', '=', $id)
            ->join('a_p_i_cities','a_p_i_advertisings.city','=','a_p_i_cities.id')
            ->join('a_p_i_categories','a_p_i_categories.city','=','a_p_i_cities.id')
            ->join('a_p_i_under_categories','a_p_i_under_categories.category','=','a_p_i_categories.id')
            ->select('a_p_i_advertisings.id AS id','a_p_i_advertisings.icon AS icon','a_p_i_advertisings.a_href AS a_href')
            ->get();
    }

}
