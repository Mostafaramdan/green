<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  App\Http\Controllers\Apis\Controllers\index;
class carts extends GeneralModel
{
    protected $table = 'carts',$appends=['product_price'];
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->users_id  = isset($params["users_id"])? $params["users_id"]: $record->users_id ;
        $record->orders_id  = isset($params["orders_id"])? $params["orders_id"]: $record->orders_id ;
        $record->quantity = isset($params["quantity"])? $params["quantity"]: $record->quantity;
        $record->price = isset($params["price"])? $params["price"]: $record->price;
        $record->offers_id = isset($params["offers_id"])? $params["offers_id"]: $record->offers_id;
        // $record->currency = isset($params["currency"])? $params["currency"]: $record->currency;
        $record->isShipment = isset($params["isShipment"])? $params["isShipment"]: $record->isShipment;
        $record->discountPercentage = isset($params["discountPercentage"])? $params["discountPercentage"]: $record->discountPercentage;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    
    public function product()
    {
        return $this->belongsTo(products::class, 'products_id');
    } 
    function GetProductPriceAttribute()
    {
        return $this->product->finalPrice * $this->quantity;
    } 
 }