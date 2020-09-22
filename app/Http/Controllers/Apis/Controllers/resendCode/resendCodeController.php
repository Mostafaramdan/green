<?php

namespace App\Http\Controllers\Apis\Controllers\resendCode;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class resendCodeController extends index
{
    public static function api()
    {
        $record=  sessions::where('tmp_token',self::$request->tmpToken)->first();
        if(helper::chkifSendTwominute($record)){ 
            $session= sessions::createUpdate([
                'id'=>$record->id,
                'code'=>helper::RandomXDigits(4),
                'tmp_token'=>helper::UniqueRandomXChar(69,'tmp_token',['sessions']),
                'users_id'=>$record->users->id
            ]);
            helper::sendSms( self::$account->phone, $session->code );
            return [
                'status'=>200,
                'tmpToken'=>$session->tmp_token
            ];
        }else{
            return [
                'status'=>416,
                'message'=>self::$messages['resendCode']["416"],
            ];
        }
    }
}