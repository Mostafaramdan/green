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
        if($cart && $cart->quantity + self::$request->quantity < 1){
            return [
                'status'=>405,
                "message"=> "you can't do this becuase quantity now = 0"
            ];
        }
        if(! $cart &&  self::$request->quantity < 1 ){
            return [
                'status'=>405,
                "message"=> "you can't do this becuase quantity now = 0"
            ];

        }
        if($cart){
            $record= carts::createUpdate([
                'id'=>$cart->id,
                'quantity'=> self::$request->quantity + $cart->quantity,
                'price' => $product->finalPrice,
                // 'currency' => self::$account->region->currency,
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
            $record = carts::createUpdate([
                'users_id'=>self::$account->id,
                'quantity'=> self::$request->quantity,
                'price' => $product->finalPrice,
                // 'currency' => self::$account->region->currency,
                'offers_id'=>$product->offer->id??null,
                'isShipment'=>$product->isShipment,
                'discountPercentage'=>$product->discount,
                'products_id'=>$product->id
            ]);
        }
        
        $records=  carts::where('users_id',self::$account->id)
                        ->where('orders_id',null)
                        ->get();
        return [
            "status"=>200,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "totalCarts"=>$records->sum('product_price') ,
            "deliveryPrice"=> self::$account->region->deliveryPrice,
            "carts"=>objects::ArrayOfObjects($records,"cart"),
        ];
    }
}