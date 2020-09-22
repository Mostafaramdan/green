<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends GeneralModel
{
    protected $table = 'products',$appends=['discount','offer'];
    public $timestamps=false;
    public static function createUpdate($params)
    {
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name_ar =isset($params['name_ar'])?$params['name_ar']: $record->name_ar;
        $record->name_en =isset($params['name_en'])?$params['name_en']: $record->name_en;
        $record->description_ar =isset($params['description_ar'])?$params['description_ar']: $record->description_ar;
        $record->description_en =isset($params['description_en'])?$params['description_en']: $record->description_en;
        $record->priceWithS_ar =isset($params['priceWithS_ar'])?$params['priceWithS_ar']: $record->priceWithS_ar;
        $record->quantity =isset($params['quantity'])?$params['quantity']: $record->quantity;
        $record->isShipment =isset($params['isShipment'])?$params['isShipment']: $record->isShipment;
        $record->categories_id =isset($params['categories_id'])?$params['categories_id']: $record->categories_id;
        $record->save();
        return $record;
    }
    public  function category(){
        return $this->belongsTo(categories::class , 'categories_id');
    }
    public  function images()
    {
        return $this->hasMany(images::class , 'products_id');
    }
    function GetDiscountAttribute()
    {
        $offer = offers::where('products_id',$this->id)->where('is_active',1)->first();
        if($offer && $offer->where('startAt','<=', date('Y-m-d H:i:s'))->where('endAt','>', date('Y-m-d H:i:s') ) ){
            return $offer->discountPercentage;
        }
        return 0;
    }
    function GetOfferAttribute()
    {
        $offer = offers::where('products_id',$this->id)->where('is_active',1)->first();
        if($offer && $offer->where('startAt','<=', date('Y-m-d H:i:s'))->where('endAt','>', date('Y-m-d H:i:s') ) ){
            return $offer;
        }
        return null;
    }
}
