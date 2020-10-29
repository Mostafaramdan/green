<?php

namespace App\Models;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;

use Illuminate\Database\Eloquent\Model;

class categories extends GeneralModel
{
    protected $table = 'categories',$appends=['discount','offer','hasOfferAr','hasOffer'];

    public $timestamps=false;
   
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->name_ar = isset($params["name_ar"])? $params["name_ar"]: $record->name_ar;
        $record->name_en = isset($params["name_en"])? $params["name_en"]: $record->name_en;
        // $record->categories_id = isset($params["categories_id"])? $params["categories_id"]: $record->categories_id;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    function GetDiscountAttribute()
    {
        $offer = offers::where('categories_id',$this->id)->where('is_active',1)->first();
        if($offer && $offer->where('startAt','<=', date('Y-m-d H:i:s'))->where('endAt','>', date('Y-m-d H:i:s') ) ){
            return $offer->discountPercentage;
        }
        return 0;
    }

    function GetOfferAttribute()
    {
        $offer = offers::where('categories_id',$this->id)->where('is_active',1)->first();
        if($offer && $offer->where('startAt','<=', date('Y-m-d H:i:s'))->where('endAt','>', date('Y-m-d H:i:s') ) ){
            return $offer;
        }
        return $offer;
    }
    function GetHasOfferAttribute()
    {
        $offer = offers::where('categories_id',$this->id)->where('is_active',1)->first();
        if($offer){
            if( $offer->endAt > date("Y-m-d h:i"))
                return true;
        }
            return false;
    }
    function GetHasOfferArAttribute()
    {
        $offer = offers::where('categories_id',$this->id)->where('is_active',1)->first();
        if($offer){
            if( $offer->endAt > date("Y-m-d h:i"))
                return 'نعم';
        }
            return 'لا';
    }


}
