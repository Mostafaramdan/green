<?php
namespace App\Http\Controllers\Apis\Controllers\getVouchers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\vouchers;
use App\Models\users_uses_vouchers;

class getVouchersController extends index
{
    public static function api()
    {
        $record=  vouchers::where('code',self::$request->code)->first();
        if($record->is_active == 0 || $record->startAt > date("Y-m-d H:i:s")){
            return [
                'status'=>415,
            ];
        }
        if($record->endAt <= date("Y-m-d H:i:s")){
            return [
                'status'=>416,
            ];
        }
        if($record->is_active == 0){
            return [
                'status'=>417,
            ];
        }
        if(users_uses_vouchers::where('users_id',self::$account->id)->where('vouchers_id',$record->id)->count() > 0){
            return [
                'status'=>418,
            ];
        }
        return [
            "status"=>200,
            "voucher"=>objects::voucher($record),
        ];
    }
}