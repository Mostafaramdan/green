<?php
namespace App\Http\Controllers\Apis\Controllers\changeLang;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class changeLangRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "lang"     =>"required|in:ar,en",
        ];

        $messages=[
            "apiToken.required"     =>400,
          
            "lang.required"         =>400,
            "lang.in"               =>405,

        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",

            "lang.required"         =>"يجب ادخال اللغة",
            "lang.in"               =>"يجب ادخال اللغة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
