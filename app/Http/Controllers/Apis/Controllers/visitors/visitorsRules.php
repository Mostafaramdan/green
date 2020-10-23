<?php
namespace App\Http\Controllers\Apis\Controllers\visitors;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class visitorsRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"       =>"required",
            "fireBaseToken"  =>"required",
            "cityId"         =>"required_if:apiToken,|exists:regions,id",

        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.unique"       =>405,

            "fireBaseToken.required"  =>400,

            "cityId.required_if"  =>400,
            "cityId.exists"    =>405,

        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال رقم الجهاز",
            "apiToken.unique"       =>" رقم الجهاز موجود مسبقاََ",

            "fireBaseToken.required"     =>"يجب ادخال الفيربيز توكن الخاص بالجهاز",

            "cityId.required_if"  =>"يجب إدخال رقم المدينة",
            "cityId.exists"    =>"رقم المدينة غير موجود",

        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

    }
}
