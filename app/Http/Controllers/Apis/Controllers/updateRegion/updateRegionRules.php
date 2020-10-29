<?php
namespace App\Http\Controllers\Apis\Controllers\updateRegion;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class updateRegionRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required|exists:users,api_token",
            'cityId' =>'nullable|exists:regions,id',
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "cityId.required"  =>400,
            "cityId.exists"    =>405,
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "cityId.required"  =>"يجب إدخال رقم المدينة",
            "cityId.exists"    =>"رقم المدينة غير موجود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
