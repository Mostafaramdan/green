<?php
namespace App\Http\Controllers\Apis\Controllers\validate;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class validateRules extends index
{
    public static function rules (){

        $rules=[
            "tmpToken" => 'required|exists:sessions,tmp_token',
            "code"     => 'required|numeric|between:1000,9999',
        ];

        $messages=[
            "tmpToken.required"     =>400,
            "tmpToken.exists"     =>408,
            
            "code.required"       =>400,
            "code.numeric"        =>405,
            "code.between"        =>405,
            "code.exists"         =>410 ,
        ];

        $messagesAr=[

            "tmpToken.required"     =>" يجب إدخال التيمب توكن  ",
            "tmpToken.exists"     =>"تيمب توكن غير صحيح",

            "code.required"       =>"يجب ادخال الكود",
            "code.numeric"       =>"يجب ادخال الكود بشكل صحيح",
            "code.between"       =>"يجب ان يكون الكود مكون من 4 أرقام",
        ];

        $messagesEn=[
            "code.exists"       =>"wrong code or expired",
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

    }
}