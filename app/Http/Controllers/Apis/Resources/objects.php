<?php
namespace App\Http\Controllers\Apis\Resources;

use App\Http\Controllers\Apis\Helper\helper ;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use App\Models\phones;
use App\Models\emails;
use App\Models\products;
use App\Models\carts;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class objects extends index{
    
    public static function region ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['name']=$record['name_'.self::$lang];
        $object['currency']=$record->currency;
        $object['stateKey']=$record->stateKey;
        $object['deliveryPrice']=$record->deliveryPrice;
        $record->logo_image==null?:$object['logo'] =Request()->root().$record->logo_image;   
        count($record->regions) > 0? $object['cities']=self::ArrayOfObjects($record->regions->sortBy('id'),'city'):null;
        return $object;
    }  
    public static function country ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['name']=$record['name_'.self::$lang];
        $object['currency']=$record->currency;
        $object['stateKey']=$record->stateKey;
        $object['deliveryPrice']=$record->deliveryPrice;
        $record->logo==null?:$object['logo'] =Request()->root().$record->logo;   
        return $object;
    }  

    public static function city ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['name']=$record['name_'.self::$lang];
        $record->serial?$object['serial']=$record->serial:null;
        $record->deliveryPrice?$object['deliveryPrice']=$record->deliveryPrice:null;
        $record->logo==null?:$object['logo'] =Request()->root().$record->logo;   
        return $object;
    }    

    public static function slider ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $record->image==null?:$object['image'] =Request()->root().$record->image;   
        $record->url?$object['url']=$record->url:null;
        return $object;
    }  
    
    public static function category ($record)
    {

        if($record == null  ) {return null;}
        $object = [];
        $object['id'] = $record->id;
        $object['name']=$record['name_'.self::$lang];
        return $object;
    }

    public static function product ($record)
    {

        if($record == null  ) {return null;}
        $object = [];
        $object['id'] = $record->id;
        isset($record['description_'.self::$lang]) ? $object['description']=$record['description_'.self::$lang] : null;
        isset($record['name_'.self::$lang]) ? $object['name']=$record['name_'.self::$lang] : null;
        $object['images']=$record->images->pluck('image_url')->toArray();
        $record->mainImage==null?$object['mainImage'] = Request()->root().'/default.png':$object['mainImage'] =Request()->root().$record->mainImage;   
        $object['price'] = $record->price;
        $object['currency']=self::$account->region->currency;
        $object['serial'] = $record->serial;
        $record->discount ? $object['discount'] = $record->discount: null ;
        $record->discount ? $object['newPrice'] = $record->price - ($record->discount/100 *$record->price) : null ;
        $object['quantity'] = $record->quantity;
        $object['isShipment'] = $record->isShipment? true : false;
        return $object;
    }

   
    public static function account ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['apiToken'] = $record->api_token;
        $object['phone'] = $record->phone;
        $object['user'] = self::user($record);
        
        return $object;
    } 

    public static function user ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $record->image?$object['image'] =Request()->root().$record->image:$object['image'] =null;   
        $object['email'] = $record->email;
        $object['lang'] = $record->lang;
        $object['city'] = self::city($record->region);
        $object['country'] = self::country($record->region->region);
        return $object;
    } 

    public static function cart ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['product']=self::product($record->product);
        $object['quantity']=$record->quantity;
        $object['price']=$record->price;
        $object['currency']=$record->currency;
        $object['discount']=$record->discount;
        $record->discount ? $object['newPrice'] = $record->price - ($record->discount/100 *$record->price) : null ;
        $object['isShipment'] = $record->isShipment? true : false;
        $object['isOffer'] = $record->offers_id? true : false;
        return $object;

    }   

    public static function orderInfo ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['location']= self::location($record->location);
        $object['isVoucher'] = $record->vouchers_id? true : false;
        $object['percentageDiscount'] =  $record->vouchers_id ? $record->voucher->discountPercentage : null ;
        $record->delivery_time  ? $object['timeOfDelivery']=self::timeOfDelivery ($record->delivery_time ) : null ;
        $record->deliveryDate ? $object['date'] = $record->deliveryDate : null ;
        $record->price ? $object['price']=$record->price : null ;
        $record->paymentType  ? $object['paymentMethod']=$record->paymentType : null  ;
        $record->notes ? $object['note']=$record->notes : null ;
        $object['deliveryPrice']=$record->deliveryPrice ;
        $object['currency']=self::$account->region->currency;
        $object['productsPrice']=$record->carts->sum('product_price');
        $object['totalPrice']=$record->carts->sum('product_price') + $record->deliveryPrice;
        $object['status']=helper::translateStatus($record->status);
        $object['carts']=self::ArrayOfObjects($record->carts,'cart');

        return $object;

    }   

    public static function location ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['longitude']=$record->longitude;
        $object['latitude']=$record->latitude;
        $object['address']=$record->address;
        return $object;
    }    

    public static function timeOfDelivery($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id'] = $record->id;
        $object['name']=$record['name_'.self::$lang];
        $object['from'] = $record->from;
        $object['to'] = $record->to;
        return $object;
    }
   
    public static function order ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id'] = $record->id;
        $object['carts'] =self::ArrayOfObjects($record->carts , 'cart');
        $object['status'] =$record->status;
        $object['currency']=self::$account->region->currency;
        $object['totalPrice'] = $record->totalPrice;
        $object['createdAt'] = Carbon::parse($record->created_at)->timestamp;
       
        return $object;
    }

    public static function notification  ($record){
        // this object take record from notify table ;
        if($record == null  ) {return null;}
        $object['id'] = $record->id;
        $object['content']=$record->notification['content_'.self::$lang];
        $record->orders? $object['order'] = self::order($record->orders):false;
        $object['isSeen'] = $record->is_seen == 1 ? true : false ;
        $object['createdAt'] = Carbon::parse($record->created_at)->timestamp;
        return $object;
    }
    public static function info ($record)
    {
        
        if($record == null) {return null;}
        $object = [];
        $object['aboutUs']=$record['aboutUs_'.self::$lang];
        $object['policyTerms']=$record['policyTerms_'.self::$lang];
        $object['email'] = $record->email;
        $object['phone'] = $record->phone;
        $object['daysToDelivery'] = $record->daysToDelivery;
        return $object;
    }
    public static function voucher ($record)
    {
        
        if($record == null) {return null;}
        $object = [];
        $object['id'] = $record->id;
        $object['discount'] = $record->discountPercentage;
        $object['maximumDeduction'] = $record->maximumDeduction;
        return $object;
    }

    
    public static function ArrayOfObjects ($Items, $objectname) { 

        if(count($Items)==0) return $Items;
        
        $Array = [];
        foreach ($Items as $Item) {
             $Array[] = self::$objectname($Item);
        }
        $final_Array=[];
        
        foreach($Array as $A)
           if($A==null)
                continue;
           else
                array_push($final_Array,$A);
        return $final_Array;
    } 
}