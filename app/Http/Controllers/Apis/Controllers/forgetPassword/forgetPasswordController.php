<?php

namespace App\Http\Controllers\Apis\Controllers\forgetPassword;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;
use App\Http\Controllers\Apis\Helper\helper ;

class forgetPasswordController extends index
{
    public static function api(){

    sessions::whereIn('id',index::$account->sessions->pluck('id')->toArray())->delete();
    $session =  sessions::createUpdate([
                    self::$account->getTable().'_id'=>self::$account->id,
                    'tmp_token'=>helper::UniqueRandomXChar(69,'tmp_token',['sessions']),
                    'code'=>helper::RandomXDigits(5)
                ]);   
    helper::sendSms( self::$account->phone, $session->code );
    return ['status'=>200,'tmpToken'=>$session->tmp_token];

    }
    
}
