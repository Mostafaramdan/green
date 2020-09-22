<?php
namespace App\Http\Controllers\Apis\Controllers\getProducts;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getProductsRules extends index
{
    public static function rules (){
        
        $rules=[
            "categoryId"   =>"required|exists:categories,id",
            "page"      =>"required|numeric"
        ];

        $messages=[
            "categoryId.required"     =>400,
            "categoryId.exists"       =>405,

            "page.required"         =>400,
            "page.numeric"          =>405
        ];

        $messagesAr=[   
            "categoryId.required"     =>"يجب ادخال رقم القسم",
            "categoryId.exists"       =>"هذا القسم غير موجود",

            "userId.exists"         =>"هذا الشخص غير موجود",
            "userId.required"       =>"يجب ادخال رقم الشخص",

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
