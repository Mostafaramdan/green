<?php
namespace App\Http\Controllers\Apis\Controllers\deleteCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;

class deleteCartController extends index
{
    public static function api()
    {
        $record  = carts::find(self::$request->cartId);
        if($record->users_id !=  self::$account->id){
            return [
                'status'=>403,
                'message'=>'unauthrized'
            ];
        }
        $record->delete();
        $records = carts::where('users_id',self::$account->id)
                        ->where('orders_id',null)
                        ->get();
        return [
            "status"=>200,
            "carts"=>objects::ArrayOfObjects($records,"cart"),
        ];
    }
}