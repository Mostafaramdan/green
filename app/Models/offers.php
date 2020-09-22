<?php

namespace App\Models;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Database\Eloquent\Model;

class offers extends GeneralModel
{
    protected $table = 'offers',$appends=['categories_id'];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->discountPercentage = isset($params["discountPercentage"])? $params["discountPercentage"]: $record->discountPercentage;
        $record->maximumDeduction = isset($params["maximumDeduction"])? $params["maximumDeduction"]: $record->maximumDeduction;
        $record->startAt = isset($params["startAt"])? $params["startAt"]: $record->startAt;
        $record->endAt = isset($params["endAt"])? $params["endAt"]: $record->endAt;
        $record->categories_id = isset($params["categories_id"])? $params["categories_id"]: $record->categories_id;
        $record->products_id = isset($params["products_id"])? $params["products_id"]: $record->products_id;
        $record->deleted_at = isset($params["deleted_at"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    function GetNameAttribute(){
        $name= 'name_'.index::$lang;
        return $this->$name;
    }
    public function product(){
        return $this->belongsTo(products::class,'products_id'); 
    }
    function GetCategoriesIdAttribute()
    {
        return $this->product->categories_id;
    } 

}
