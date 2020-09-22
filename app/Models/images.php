<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Support\Str;

class images extends GeneralModel
{
    protected $table = 'images',$appends=['image_url'];
    public $timestamps=false;
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->image =isset($params['image'])?helper::base64_image( $params['image'],'products'): $record->image;
        $record->products_id  = isset($params["products_id"]) ? $params["products_id"]: $record->products_id;
        $record->save();
        return $record;
    }
    function GetImageUrlAttribute()
    {
        return Request()->root().$this->image ;
    }
}