<?php


namespace App\Repositories;
use App\Models\Models\templates_properties;
use App\Models\Models\templates_undercategory;


class APITemplates_properties_repository extends BaseRepository
{
    public function GetPropertiesFromUndercategory($under_category){
        $template_undercategoryID = templates_undercategory::where('title',$under_category)
            ->select('id')
            ->get();
        $under_categoryID = $template_undercategoryID[0]['id'];
        //dd($under_categoryID);
        $properties = templates_properties::where('under_category',$under_categoryID)
            ->get();
        return $properties;
    }
}
