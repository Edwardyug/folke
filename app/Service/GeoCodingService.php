<?php


namespace App\Service;


use App\Models\Models\undercity;
use Http;
use phpDocumentor\Reflection\Types\This;

class GeoCodingService
{
    private static function getkey(){
        return 'AIzaSyB1fIS8VG0_l7eJ_RFeeC_6SEVcvs7W0PE';
    }

    public static function GetCoordinate($address){
       // $json = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.self::getkey().'&language=NO&components=country:NO'), true);
        $json = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => self::getkey(),
            'language'=>'NO'//,
            //'components'=>'country:NO'
        ])->json();
          $v=\Validator::make($json,[
                'results'=>'required',
                'results.*.geometry'=>'required',
                'results.*.geometry.location'=>'required',
            ]
        );

        if ($v->validated()) {
            //dd($json['results'][0]['geometry']['location']['lat']);
            return [
                'lat' => $json['results'][0]['geometry']['location']['lat'],
                'lon' => $json['results'][0]['geometry']['location']['lng'],
            ];
        } else {
            return [
                'lat'=>'ZERO_RESULT',
                'lon'=>'ZERO_RESULT',
            ];
        }
    }

    public static function Nearestcity($city){
        $result = undercity::where('undercities.title','=',$city)
            ->join('a_p_i_cities','a_p_i_cities.id','=','undercities.city_id')
            ->select('a_p_i_cities.id','a_p_i_cities.title')
            ->get();
        return $result;
    }

    public static function RequestCity($lat,$lon){
        $json = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lon.'&result_type=locality&key='.self::getkey().'&language=NO'), true);
        //dd($json);
        $v = \Validator::make($json,[
           'results'=>'required',
           'results.*.address_components'=>'required',
           'results.*.address_components.*.long_name'=>'required',
        ]);
       // dd($json);
        $city[] = [
            'id'=>'72',
            'title' => 'Oslo',
        ];
        if ($v->fails()){
            return  $city;
        }
        if ($v->validated()){
            $result = $json['results'][0]['address_components'][0]['long_name'];
            $NearestCity = self::Nearestcity($result);
            $city = $NearestCity;
        }
        return $city;
    }
}
