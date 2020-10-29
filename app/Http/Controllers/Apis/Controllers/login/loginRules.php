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
            "phone"    =>"required:apiToken,|numeric|between:10000000,999999999999999",
            "fireBaseToken"  =>"required_if:apiToken,",
            "cityId" =>"required_if:apiToken,|exists:regions,id",
            "lang"     =>"in:ar,en",
            'apiToken' => 'exists:users,api_token'
        ];

        $messages=[
            "lang.in"            =>405,

            "type.required"      =>400,
            "type.in"            =>405,

            "phone.required"     =>400,
            "phone.numeric"      =>405,
            "phone.between"      =>405,

            "cityId.required_if"  =>400,
            "cityId.exists"    =>405,

            "fireBaseToken.required_if" =>400,

            'apiToken.exists' => 405
        ];

        $messagesAr=[   
            "type.required"     =>"يجب ادخال نوع المستخدم",
            "type.in"           =>" users Or Providers يجب ان يكون النوع  ",

            "phone.required" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.numeric"     =>"يجب ادخال رقم التليفون بشكل صحيح",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",

            "cityId.required_if"  =>"يجب إدخال رقم الدولة",
            "cityId.exists"    =>"رقم الدولة غير موجود",

            "fireBaseToken.required_if"=>"يجب ادخال الرقم الخاص بالجهاز ",

            "apiToken.exists"=>"توكن زائر غير موجود ",
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
