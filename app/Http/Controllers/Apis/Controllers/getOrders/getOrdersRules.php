<?php
namespace App\Http\Controllers\Apis\Controllers\getOrders;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getOrdersRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"   =>"required|exists:users,api_token",
            'status'    =>"Required|in:current,past",
            "page"      =>"required|numeric"
        ];

        $messages=[
            "apiToken.required"   =>400,
            "apiToken.exists"     =>405,

            "status.Required"     =>400,
            "status.in"           =>405,

            "page.required"       =>400,
            "page.numeric"        =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "status.Required"          =>"يجب إدخال الحالة    ",
            "status.*.in"             =>"  current,past :  تحديد النوع يجب ان يكون  :",

            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
