<?php
namespace App\Http\Controllers\Apis\Controllers\updateRegion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;
use App\Models\regions;

class updateRegionController extends index
{
    public static function api()
    {
        if(regions::find(self::$request->cityId)->regions_id == null){
            return [
                'status'=>405,
                "message"=> "you must send city id as a city not acountry ."
            ];
        }
        users::createUpdate([
            'id'=>self::$account->id,
            'regions_id'=>self::$request->cityId,
        ]);       
        return [
            "status"=>200
        ];
    }
}