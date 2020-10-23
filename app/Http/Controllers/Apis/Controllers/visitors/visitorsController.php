<?php
namespace App\Http\Controllers\Apis\Controllers\visitors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;

class visitorsController extends index
{
    public static function api()
    {
        $user = users::where('device_id',self::$request->apiToken)->first();
        if($user){
             $user->regions_id= self::$request->cityId??$user->regions_id;
             $user->fireBaseToken= self::$request->fireBaseToken??$user->fireBaseToken;
             $user->save();
            return [
                "status"=>200,
                'apiToken'=>users::where('device_id',self::$request->apiToken)->first()->api_token
            ];
    
        }
        $record=  users::createUpdate([
            'device_id'=>self::$request->apiToken,
            'fireBaseToken'=>self::$request->fireBaseToken,
            'regions_id'=>self::$request->cityId,
            'lang'=>'ar'
        ]);
        return [
            "status"=>200,
            'apiToken'=>$record->api_token
        ];
    }
}