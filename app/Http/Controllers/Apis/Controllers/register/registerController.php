<?php

namespace App\Http\Controllers\Apis\Controllers\register;

use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sessions;

class registerController extends index
{    
    public static function api (){

        $request=self::$request;
        $type="App\Models\\".self::$request->type;
        $record= $type::createUpdate([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'lang'=>$request->lang,
                    'image'=>$request->image,
                    'password'=>$request->password,
                    'image'=>$request->image,  
                    'lang'=>$request->lang, 
                    'isAndroid'=>$request->isAndroid,
                    'fireBaseToken'=>$request->fireBaseToken,
                ]);
        $session = sessions::createUpdate([
                $record->getTable().'_id' =>$record->id,
                'code'=>helper::RandomXDigits(5)
            ]);
        helper::sendSms( $record->phone, $session->code );
        return [
            'status'=>200,
            'message'=>self::$messages['register']["200"],
            'account'=>objects::account( $record)
        ];
    }
}