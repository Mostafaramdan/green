<?php
namespace App\Http\Controllers\Apis\Controllers\countCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;

class countCartController extends index
{
    public static function api()
    {
        $records=  carts::where('users_id',self::$account->id)
                        ->where('orders_id',null)
                        ->get();
        return [
            "status"=>200,
            "count"=>$records->sum('quantity'),
        ];
    }
}