<?php
namespace App\Http\Controllers\Apis\Controllers\addToCart;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class addToCartRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"    =>"required|exists:users,api_token",
            "productId"   =>"required|exists:products,id",
            "quantity"    =>"required|numeric|min:1"
        ];

        $messages=[
            "apiToken.required"     =>400,
            "apiToken.exists"       =>405,

            "productId.required"       =>400,
            "productId.exists"         =>405,

            "quantity.required"         =>400,
            "quantity.numeric"          =>405
        ];

        $messagesAr=[   
            "apiToken.required"     =>"يجب ادخال التوكن",
            "apiToken.exists"       =>"هذا التوكن غير موجود",

            "productId.exists"      =>"هذا المنتج غير موجود",
            "productId.required"    =>"يجب ادخال رقم المنتج",

            "quantity.required"     =>"يجب ادخال الكمية ",
            "quantity.numeric"      =>"يجب ادخال  الكمية بشكل صحيح",
            "quantity.min"          =>"يجب ادخال  الكمية بشكل صحيح",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
