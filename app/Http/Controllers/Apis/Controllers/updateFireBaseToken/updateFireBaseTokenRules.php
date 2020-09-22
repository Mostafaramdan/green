<?php
namespace App\Http\Controllers\Apis\Controllers\updateFireBaseToken;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

class updateFireBaseTokenRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required",
            "fireBaseToken"  =>"required",
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "fireBaseToken.required"       =>400,
            "fireBaseToken.unique"         =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "fireToken.unique"      =>"رقم الجهاز مكرر مسبقا",
            "fireToken.required"    =>"يجب ادخال  رقم الجهاز",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
