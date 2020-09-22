<?php
namespace App\Http\Controllers\Apis\Controllers\validate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\sessions;

class validateController extends index
{
    public static function api()
    {
        $record=  sessions::where('tmp_token',self::$request->tmpToken)->first();
        if($record->users->is_active){
            if($record->code == self::$request->code){
                if($record->tmp_phone){
                    $record->users->phone= $record->tmp_phone;
                    $record->users->save();
                }
                $record->delete();
                return [
                    'status'=>200,
                    "account"=>objects::account($record->users,"account"),
                ];
            }else{
                return [
                    'status'=>409,
                    "mesaseg"=>'wronge code',
                ];
            }
        }else{
            return [
                'status'=>402,
                "message"=>"account is inactive",
            ];
        }
    }
}