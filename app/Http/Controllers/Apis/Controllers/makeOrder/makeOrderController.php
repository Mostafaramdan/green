<?php
namespace App\Http\Controllers\Apis\Controllers\makeOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\orders;
use App\Models\carts;
use App\Models\vouchers;
use App\Models\users_uses_vouchers;
use App\Models\locations;
use App\Models\products;

class makeOrderController extends index
{
    public static function api()
    {
        $carts=  carts::where('users_id',self::$account->id)
                      ->where('orders_id',null)
                      ->get();
        $total = 0;
        foreach($carts as $cart){
            $product = products::find($cart->products_id);
            if($product->quantity < $cart->quantity){
                return [
                    'status'=>407,
                    'product'=>objects::product($product),
                    'message'=>'This product is out of stock ',
                    "availbleQuantity"=>$product->quantity
                ];
            }
        }

        foreach($carts as $cart){
            if($cart->offers_id){
                $total += ($cart->price -( $cart->price/100 * $cart->discount) ) * $cart->quantity;
            }else{
                $total += $cart->price  * $cart->quantity;
            }
        }
        $discount = 0;
        $voucher= null ;
        if(self::$request->vouchers){
            $voucher = vouchers::where('code',self::$request->vouchers)->first();
            if(
                $voucher && $voucher->is_active && $voucher->timeToUse > 0 &&
                $voucher->startAt <= date("Y-m-d H:i") &&
                $voucher->endAt	 > date("Y-m-d H:i") && 
                users_uses_vouchers::where('users_id' ,self::$account->id)
                                   ->where('vouchers_id' , $voucher->id)
                                   ->count()
               ){
                $discount = $total/100 * $voucher->discountPercentage;
                if($discount > $voucher->maximumDeduction ){
                    $discount= $voucher->maximumDeduction;
                }
                $total -= $total ;
            }
            $voucher->timeToUse--;
            $voucher->save();
            users_uses_vouchers::createUpdate([
                'users_id' =>self::$account->id,
                'vouchers_id' => $voucher->id,
            ]);
        }
        $location = locations::createUpdate([
            'longitude'=>self::$request->location['longitude'],
            'latitude'=>self::$request->location['latitude'],
            'address'=>self::$request->location['address'],
            'users_id'=>self::$account->id
        ]);

        $order = orders::createUpdate([
            'users_id' =>self::$account->id,
            'totalPrice' =>$total,
            'paymentType' =>self::$request->paymentMethod,
            'locations_id'=>$location->id,
            'vouchers_id' => $voucher->id,
            'deliveryDate' =>self::$request->deliveryDate,
            'delivery_time_id' =>self::$request->timeOfDeliveryId,
            'notes' =>self::$request->notes,
            'deliveryPrice' =>0,
            'status'=>'waiting'
        ]);
        foreach($carts as $cart){
            $cart->orders_id= $order->id;
            $cart->save();
            $product= products::find($cart->products_id);
            $product->quantity -= $cart->quantity;
            $product->save();
        }

        return [
            "status"=>200,
            "orderId"=>$order->id,
        ];
    }
}