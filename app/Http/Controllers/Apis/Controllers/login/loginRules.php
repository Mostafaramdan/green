<?php

namespace App\Http\Controllers\Apis\Controllers\login;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
class loginRules extends index
{    

    public static function rules (){
        
        $rules=[
            "phone"    =>"required|numeric|between:10000000,999999999999999",
            "fireBaseToken"  =>"required",
            "countryId" =>"required|exists:regions,id",
            "lang"     =>"in:ar,en",
        ];

        $messages=[
            "lang.in"            =>405,

            "type.required"      =>400,
            "type.in"            =>405,

            "phone.required"     =>400,
            "phone.numeric"      =>405,
            "phone.between"      =>405,

            "countryId.required"  =>400,
            "countryId.exists"    =>405,

            "fireBaseToken.required" =>400,
        ];

        $messagesAr=[   
            "type.required"     =>"يجب ادخال نوع المستخدم",
            "type.in"           =>" users Or Providers يجب ان يكون النوع  ",

            "phone.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.numeric"     =>"يجب ادخال رقم التليفون بشكل صحيح",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",

            "countryId.required"  =>"يجب إدخال رقم الدولة",
            "countryId.exists"    =>"رقم الدولة غير موجود",

            "fireBaseToken.required"=>"يجب ادخال الرقم الخاص بالجهاز ",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        // return helper::validateAccount()??null;
        return  null;
    }

}
