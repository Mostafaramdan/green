<?php

namespace App\Models;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;

use Illuminate\Database\Eloquent\Model;

class categories extends GeneralModel
{
    protected $table = 'categories',$appends=['name'];

    public $timestamps=false;
   
    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->name_ar = isset($params["name_ar"])? $params["name_ar"]: $record->name_ar;
        $record->name_en = isset($params["name_en"])? $params["name_en"]: $record->name_en;
        $record->categories_id = isset($params["categories_id"])? $params["categories_id"]: $record->categories_id;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    function GetNameAttribute(){
        $name= 'name_'.index::$lang??'ar';
        return $this->$name;
    }
}
