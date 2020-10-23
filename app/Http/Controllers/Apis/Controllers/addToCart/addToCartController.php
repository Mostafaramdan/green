<?php
namespace App\Http\Controllers\Apis\Controllers\addToCart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\carts;
use App\Models\products;

class addToCartController extends index
{
    public static function api()
    {
        $product=  products::find(self::$request->productId);
        if(!$product->is_active){
            return [
                'status'=>402,
                'message'=>'product is inActive'
            ];
        }
        if($product->quantity < self::$request->quantity){
            return [
                'status'=>407,
                'message'=>'This product is out of stock '
            ];
        }

        $cart = carts::where('products_id',self::$request->productId)
                     ->where('users_id',self::$account->id)
                     ->where('orders_id',null)
                     ->first();
        if($cart->quantity + self::$request->quantity < 1){
            return [
                'status'=>405,
                "message"=> "you can't do this becuase quantity now = 0"
            ];
        }
        if($cart){
            carts::createUpdate([
                'id'=>$cart->id,
                'quantity'=> self::$request->quantity + $cart->quantity,
                'price' => $product->finalPrice,
                'currency' => self::$request->currency,
                'offers_id'=>$product->offer->id??null,
                'isShipment'=>$product->isShipment,
                'discountPercentage'=>$product->discount,
            ]);
            if($product->price != $cart->price ){
                return [
                    'status'=>201,
                    'currentPrice'=>$product->price
                ];
            }
        }else{
            carts::createUpdate([
                'users_id'=>self::$account->id,
                'quantity'=> self::$request->quantity,
                'price' => $product->finalPrice,
                'currency' => self::$request->currency,
                'offers_id'=>$product->offer->id??null,
                'isShipment'=>$product->isShipment,
                'discountPercentage'=>$product->discount,
                'products_id'=>$product->id
            ]);
        }
        return [
            "status"=>200,
        ];
    }
}