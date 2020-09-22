<?php
namespace App\Http\Controllers\Apis\Controllers\getInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\app_settings;

class getInfoController extends index
{
    public static function api()
    {
        $record=  app_settings::first();
        if(!$record){
            app_settings::createUpdate([
                'policyTerms_ar'=>"policyTerms_ar",
                'policyTerms_en'=>"policyTerms_en",
                'aboutUs_ar'=>"aboutUs_ar",
                'aboutUs_en'=>"aboutUs_en",
                'email'=>"email",
                'phone'=>"phone",
                'daysToDelivery'=>1,
            ]);
        }
        return [
            "status"=>200,
            "info"=>objects::info($record)
        ];
    }
}