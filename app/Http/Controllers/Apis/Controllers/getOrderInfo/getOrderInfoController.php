<?php
namespace App\Http\Controllers\Apis\Controllers\getOrderInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;

class getOrderInfoController extends index
{
    public static function api()
    {
        $record=  orders::find(self::$request->orderId);
        return [
            "status"=>200,
            "orderInfo"=>objects::orderInfo($record),
        ];
    }
}