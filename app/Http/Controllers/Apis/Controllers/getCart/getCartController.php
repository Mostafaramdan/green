<?php
namespace App\Http\Controllers\Apis\Controllers\getCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;

class getCartController extends index
{
    public static function api()
    {
        $records=  carts::where('users_id',self::$account->id)
                        ->where('orders_id',null)
                        ->get();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "carts"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"cart"),
        ];
    }
}