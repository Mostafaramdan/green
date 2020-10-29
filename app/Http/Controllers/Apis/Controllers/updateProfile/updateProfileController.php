<?php
namespace App\Http\Controllers\Apis\Controllers\updateProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;
use App\Models\sessions;

class updateProfileController extends index
{
    public static function api()
    {
        users::createUpdate([
            'id'=>self::$account->id,
            'name'=>self::$request->name,
            'email'=>self::$request->email,
            'image'=>self::$request->image,
            'regions_id'=>self::$request->cityId,
            'lang'=>self::$request->lang,
        ]);
        $session= null ;
        if(self::$request->phone && self::$request->phone != self::$account->phone){
            sessions::where('users_id',self::$account->id)->delete();
            $session= sessions::createUpdate([
                'users_id'=>self::$account->id,
                'tmp_phone'=>self::$request->phone,
                'tmp_token'=>helper::UniqueRandomXChar(69,'tmp_token',['sessions']),
                'code'=>helper::RandomXDigits(4)
            ]);
            helper::sendSms( self::$request->phone, $session->code );
        }

        return [
            "status"=>200,
            "user"=>objects::user(users::find(self::$account->id)),
            "tmpToken"=>$session->tmp_token??null
        ];
    }
}