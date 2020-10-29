<?php
namespace App\Http\Controllers\Apis\Controllers\updateProfile;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class updateProfileRules extends index
{
    public static function rules ()
    {   
        $rules=[
            "apiToken"  =>"required|exists:users,api_token",
            "name"      =>"min:3|max:30",
            "image"     =>"nullable",
            "email"     =>"nullable|email|unique:users,email,".self::$account->id,
            "phone"    =>"nullable|numeric|between:10000000,999999999999999|unique:users,phone,".self::$account->id,
            'cityId' =>'nullable|exists:regions,id'
        ];

        $messages=[
            "apiToken.required"   =>400,
            "apiToken.exists"     =>405,

            "name.min"            =>405,
            "name.max"            =>405,
  
            "email.email"         =>405,
            "email.unique"        =>411,

            "phone.required"     =>400,
            "phone.numeric"      =>405,
            "phone.between"      =>405,
            "phone.unique"       =>410,


            "cityId.required"  =>400,
            "cityId.exists"    =>405,

        ];

        $messagesAr=[   
            "apiToken.required"   =>"يجب ادخال التوكن",
            "apiToken.exists"     =>"هذا التوكن غير موجود",

            "name.min"            =>"يجب ان لا يقل الاسم عن 3 حروف",
            "name.max"            =>"يجب ان لا يزيد الاسم عن ",
  
            "email.email"         =>"يجب ادخال البريد الالكتروني بشكل صحيح",
            "email.unique"        =>" هذا البريد موجود ",

            "phone.required_if"   =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.numeric"       =>"يجب ادخال رقم التليفون بشكل صحيح",
            "phone.between"       =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"        =>" هذا الرقم موجود ",

            "cityId.required"  =>"يجب إدخال رقم الدولة",
            "cityId.exists"    =>"رقم الدولة غير موجود",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
