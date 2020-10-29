<?php
namespace App\Http\Controllers\Apis\Controllers\login;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\notifications;
use App\Models\users;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class loginController extends index
{
    public static function api()
    {

        $user = users::where('phone',self::$request->phone)->first();
        if(!$user){
            $user = users::where('api_token',self::$request->apiToken)->first();
        }
        if($user){
            if(!$user->is_active){
                return [
                    'status'=>407,
                ];
            }else{
                sessions::where('users_id',$user->id)->delete();
                $user = users::createUpdate([
                    "id"=>$user->id,
                    'fireBaseToken'=>self::$request->fireBaseToken,
                    'device_id'=>$user->device_id,
                    'regions_id'=>self::$request->cityId,
                    'phone'=>self::$request->phone,
                    'lang'=>self::$request->lang,
                ]);
                $session =  sessions::createUpdate([
                    'users_id'=>$user->id,
                    'tmp_token'=>helper::UniqueRandomXChar(69,'tmp_token',['sessions']),
                    'code'=>helper::RandomXDigits(4)
                ]);   
                helper::sendSms($user->phone, $session->code);
                return [
                    'status'=>200,
                    'tmpToken'=>$session->tmp_token,
                    "apiToken"=>$user->api_token
                ];
            }
        }else{
            $user = users::createUpdate([
                'fireBaseToken'=>self::$request->fireBaseToken,
                'phone'=>self::$request->phone,
                'regions_id'=>self::$request->cityId,
                'lang'=>self::$request->lang,
            ]);
            $session =  sessions::createUpdate([
                'users_id'=>$user->id,
                'tmp_token'=>helper::UniqueRandomXChar(69,'tmp_token',['sessions']),
                'code'=>helper::RandomXDigits(4)
            ]);   
            helper::sendSms($user->phone, $session->code);
            return [
                'status'=>200,
                'tmpToken'=>$session->tmp_token
            ];
        }
    }
}