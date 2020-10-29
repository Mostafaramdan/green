<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Http\Controllers\Apis\Controllers\index;

class orders extends GeneralModel
{
    protected $table = 'orders',$appends=['status_ar','user_name','user_phone','mapLink'];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->status	 = isset($params["status"])? $params["status"]: $record->status;
        $record->totalPrice	 = isset($params["totalPrice"])? $params["totalPrice"]: $record->totalPrice;
        $record->paymentType	 = isset($params["paymentType"])? $params["paymentType"]: $record->paymentType;
        $record->deliveryPrice	 = isset($params["deliveryPrice"])? $params["deliveryPrice"]: $record->deliveryPrice;
        $record->currency = isset($params["currency"])? $params["currency"]: $record->currency;
        $record->deliveryDate	 = isset($params["deliveryDate"])? $params["deliveryDate"]: $record->deliveryDate;
        $record->notes	 = isset($params["notes"])? $params["notes"]: $record->notes;
        $record->locations_id	 = isset($params["locations_id"])? $params["locations_id"]: $record->locations_id;
        $record->vouchers_id	 = isset($params["vouchers_id"])? $params["vouchers_id"]: $record->vouchers_id;
        $record->delivery_time_id	 = isset($params["delivery_time_id"])? $params["delivery_time_id"]: $record->delivery_time_id;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function user(){
        return $this->belongsTo(users::class,"users_id");
    }
    public function location(){
        return $this->belongsTo(locations::class,"locations_id");
    }
    public function voucher(){
        return $this->belongsTo(vouchers::class,"vouchers_id");
    }  
    public function delivery_time(){
        return $this->belongsTo(delivery_time::class,"delivery_time_id");
    }
    public function carts(){
        return $this->hasMany(carts::class,'orders_id');
    }
    function GetStatusArAttribute(){
        index::$lang= 'ar';
        return self::$helper::translateStatus($this->status);
    }
    function GetUserNameAttribute(){
        return $this->user->name;
    }
    function GetUserPhoneAttribute(){
        
        return $this->user->phone;
    }
    function GetMapLinkAttribute()
    {
        $longitude= $this->location->longitude??"0";
        $latitude= $this->location->latitude??"0";
        return "https://maps.google.com/?q=".$latitude.",".$longitude;
    }

}