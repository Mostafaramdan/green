<?php

namespace App\Http\Controllers\Apis\Controllers\register;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Models\regions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class registerRules extends index
{
    
    public static function rules ()
    {        

        $rules=[
            "name"     =>"required|min:3",
            "type"     =>"required|in:users,providers",
            "phone"    =>"required|numeric|between:10000000,999999999999999|unique:users,phone|unique:providers,phone",
            "email"    =>"unique:users,phone|unique:providers,email",
            'image'    =>"nullable",
            "password" =>"required|min:6",
            "lang"     =>"required|in:ar,en",
            "isAndroid"=>"required|in:0,1"
        ];

        $messages=[
            "name.required"      =>400,
            "name.min"           =>405,

            "type.required"      =>400,
            "type.in"            =>405,

            "phone.required"     =>400,
            "phone.numeric"      =>405,
            "phone.between"      =>405,
            "phone.unique"       =>408,

            "email.unique"       =>408,

            "image.required"     =>400,

            "password.required"  =>400,
            "password.min"       =>405,

            "lang.required"      =>400,
            "lang.in"            =>405,

            "isAndroid.required" =>405,
            "isAndroid.in"       =>405
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "type.required"     =>"يجب ادخال نوع المستخدم",
            "type.in"           =>" users Or Providers يجب ان يكون النوع  ",

            "phone.required"    =>"يجب ادخال رقم التليفون   ",
            "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "email.unique"      =>"هذا البريد الإلكتروني مسجل مسبقا",

            "image.required"    =>"يجب ادخال صورة المستخدم ",

            "password.required" =>"يجب ادخال الرقم السري",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

            "isAndroid.required"=>"يجب ادخال نوع النظام التشغيل ",
            "isAndroid.in"      =>"يجب ادخال نوع النظام التشغيل بشكل صحيح",

            "lang.required"     =>"يجب ادخال اللغة ",
            "lang.in"           =>" ar , en يجب ادخال اللغة بشكل صحيح ",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=self::$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    

        // if(regions::findActive(self::$request->regionId) &&
        //  regions::findActive(self::$request->regionId)->regions_id)
        //     return ['status'=>405,'message'=>self::$lang=="ar"?'هذه المدينة غير صالحة ادخل مدينة اخري':'invalid city, choose another city .'];
    }
}