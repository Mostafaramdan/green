<?php
namespace App\Http\Controllers\Apis\Controllers\contactUs;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class contactUsRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required_if:phone,",
            'name'      =>'required_if:apiToken,',
            'phone'      =>'required_if:apiToken,',
            "message"    =>"required|min:3",
        ];

        $messages=[
            "apiToken.required_if"     =>400,
            "apiToken.exists"       =>405,

            "apiToken.required_if"     =>400,

            "name.required_if"     =>400,

            "phone.required_if"     =>400,

            "message.required"      =>400,
            "message.min"           =>405,
        ];

        $messagesAr=[   
            "apiToken.required_if"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "name.required_if"     =>"يجب ادخال الاسم",

            "phone.required_if"     =>"يجب ادخال رقم التليفون",

            "message.required"      =>"يجب ادخال الرسالة",
            "message.min"           =>"يجب ان لا تقل الرسالة عن 3 حروف",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        // return helper::validateAccount()??null;
    }
}
