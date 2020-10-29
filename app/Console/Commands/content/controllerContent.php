<?php

namespace App\Console\Commands\content;

class controllerContent
{
  
public static function index ( $fileName){

return 
'<?php
namespace App\Http\Controllers\Apis\Controllers\\'.$fileName.';

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\ModelName;

class '.$fileName.'Controller extends index
{
    public static function api(){

        $records=  ModelName::allActive();
        $message="";
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "arrayobjectsNAme"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"objectsNAme"),
            "message"=>$message
        ];
    }
}'; 
   }
}
