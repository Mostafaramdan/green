<?php
namespace App\Http\Controllers\Apis\Controllers\updateCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;

class updateCartController extends index
{
    public static function api()
    {
        $record=  carts::find(self::$request->cartId);
        $product = products::find($record->products_id);
        if($product->quantity < self::$request->quantity ){
            return [
                'status'=>407,
                'message'=>'This product is out of stock '
            ];
        }

        carts::createUpdate([
            'id'=>$record->id,
            'quantity'=> self::$request->quantity ,
            'price' => $product->priceWithS_ar,
            'offers_id'=>$product->offer->id??null,
            'isShipment'=>$product->isShipment,
            'discountPercentage'=>$product->discount,
        ]);
        if($product->priceWithS_ar != $record->price ){
            return [
                'status'=>201,
                'currentPrice'=>$product->priceWithS_ar
            ];
        }
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