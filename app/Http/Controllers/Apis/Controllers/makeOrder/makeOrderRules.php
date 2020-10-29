<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class makeOrderRules extends index
{
    public static function rules (){
        
        $rules=[
            "apiToken"           =>"required|exists:users,api_token",
            'location'           =>'required|array',
            'location.longitude' =>'required',
            'location.latitude'  =>'required',
            'location.address'   =>'required',
            'vouchers'           =>'nullable|exists:vouchers,code',
            "timeOfDeliveryId"   =>"required|exists:delivery_time,id",
            "date"       =>"required|date_format:Y-m-d",
            "paymentMethod"      =>'required|in:Cash',
            'note'               =>'nullable' ,
            // "currency"     =>"required|in:SAR,EGP,AED,KW"
                  
        ];

        $messages=[
            "apiToken.required"             =>400,
            "apiToken.exists"               =>405,

            "location.required"             =>400,
            "location.array"                =>405,

            "location.longitude.required"   =>400,
            "location.longitude.required"   =>400,
            "location.longitude.required"   =>400,

            "vouchers.exists"               =>405,
            
            "timeOfDeliveryId.required"     =>400,
            "timeOfDeliveryId.exists"       =>405,

            "date.date_format"              =>405,

            "paymentMethod.required"        =>400,
            "paymentMethod.in"              =>405,

            "currency.required"             =>400,
            "currency.in"                   =>405,

        ];

        $messagesAr=[   
            "apiToken.required"        =>"يجب ادخال التوكن",
            "apiToken.exists"          =>"هذا التوكن غير موجود",

            "location.required"        =>"يجب إدخال الموقع ",
            "location.array"           =>"(longitude , latitude , address) يجب إدخال الموقع بشكل صحيح ",

            "location.*.required"      =>"(longitude , latitude , address) يجب إدخال الموقع بشكل صحيح ",

            "vouchers.exists"          =>"كود خصم غير موجود",
            
            "timeOfDeliveryId.required"=>"يجب أدخال رقم وقت التوصيل",
            "timeOfDeliveryId.exists"  =>"رقم وقت التوصيل غير موجود",

            "date.required"=>"يجب أدخال  وقت التوصيل",
            "date.date_format"  =>"(Y-m-d) يجب إدخال صيغة التاريخ بشكل صحيح ",

            "paymentMethod.required"    =>"يجب إدخال طريقة الدفع",
            "paymentMethod.in"          =>"(Cash , ) يجب إدخال طريقة الدفع بشكل صحيح ",

            "currency.required"         =>400,
            "currency.in"         =>405,
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
