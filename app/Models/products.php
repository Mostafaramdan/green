<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends GeneralModel
{
    protected $table = 'products',$with=["images"],$appends=[
                                                            'discount','offer',
                                                            'hasOfferAr','hasOffer',
                                                            'price','finalPrice',
                                                            'isShipmentAr'
                                                            ];
    public $timestamps=false;
    public static function createUpdate($params)
    {
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name_ar =isset($params['name_ar'])?$params['name_ar']: $record->name_ar;
        $record->name_en =isset($params['name_en'])?$params['name_en']: $record->name_en;
        $record->description_ar =isset($params['description_ar'])?$params['description_ar']: $record->description_ar;
        $record->description_en =isset($params['description_en'])?$params['description_en']: $record->description_en;
        $record->price_KWD =isset($params['price_KWD'])?$params['price_KWD']: $record->price_KWD;
        $record->price_EGP =isset($params['price_EGP'])?$params['price_EGP']: $record->price_EGP;
        $record->price_SAR =isset($params['price_SAR'])?$params['price_SAR']: $record->price_SAR;
        $record->price_AED =isset($params['price_AED'])?$params['price_AED']: $record->price_AED;
        $record->quantity =isset($params['quantity'])?$params['quantity']: $record->quantity;
        $record->isShipment =isset($params['isShipment'])?$params['isShipment']: $record->isShipment;
        $record->serial =isset($params['serial'])?$params['serial']: $record->serial;
        $record->mainImage =isset($params['mainImage'])?self::$helper::base64_image( $params['mainImage'],'products'): $record->mainImage;
        $record->categories_id =isset($params['categories_id'])?$params['categories_id']: $record->categories_id;
        isset($params['id'])?:$record->created_at = date("Y-m-d H:i:s");
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
    function GetHasOfferAttribute()
    {
        $offer = offers::where('products_id',$this->id)->where('is_active',1)->first();
        if($offer){
            if($offer->startAt <= date("Y-m-d h:i") && $offer->endAt > date("Y-m-d h:i"))
                return true;
        }
            return false;
    }
    function GetHasOfferArAttribute()
    {
        $offer = offers::where('products_id',$this->id)->where('is_active',1)->first();
        if($offer){
            if($offer->startAt <= date("Y-m-d h:i") && $offer->endAt > date("Y-m-d h:i"))
                return 'نعم';
        }
            return 'لا';
    }

    function GetPriceAttribute()
    {
        $currency = self::$account->region->currency ?? "EGP";
        $price = 'price_'.$currency;
        return $this->getAttribute($price);

    }
    function GetFinalPriceAttribute()
    {
        return $this->discount ?$this->price - ($this->discount/100 *$this->price) : $this->price;

    }
    function getIsShipmentArAttribute()
    {
        if($this->isShipment){
            return 'نعم';
        }
        return 'لا';
    }
    
}
