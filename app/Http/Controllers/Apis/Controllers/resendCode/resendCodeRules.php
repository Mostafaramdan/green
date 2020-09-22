<?php

namespace App\Http\Controllers\Apis\Controllers\resendCode;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
class resendCodeRules extends index
{    

    public static function rules (){

        $rules=[
            "tmpToken" => 'required|exists:sessions,tmp_token',
        ];

        $messages=[
            "tmpToken.required"     =>400,
            "tmpToken.exists"     =>408,
        ];

        $messagesAr=[

            "tmpToken.required"   =>" يجب إدخال التيمب توكن  ",
            "tmpToken.exists"     =>"تيمب توكن غير صحيح",
        ];

        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }
    }
}