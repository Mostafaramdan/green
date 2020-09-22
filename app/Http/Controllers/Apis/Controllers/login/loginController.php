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
        if(self::$account){
            if(!self::$account->is_active){
                return [
                    'status'=>407,
                ];
            }else{
                sessions::where(self::$account->getTable().'_id',self::$account->id)->delete();
                $session =  sessions::createUpdate([
                self::$account->getTable().'_id'=>self::$account->id,
                    'tmp_token'=>helper::UniqueRandomXChar(69,'tmp_token',['sessions']),
                    'code'=>helper::RandomXDigits(4)
                ]);   
                return [
                    'status'=>200,
                    'tmpToken'=>$session->tmp_token
                ];
            }
        }else{
            $user = users::createUpdate([
                'fireBaseToken'=>self::$request->fireBaseToken,
                'phone'=>self::$request->phone,
                'regions_id'=>self::$request->countryId,
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