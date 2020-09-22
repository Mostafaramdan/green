<?php

namespace App\Http\Controllers\Apis\Controllers\contacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\contacts;

class contactsController extends index
{
    public static function api(){

        contacts::createUpdate([
            'message'=>self::$request->message,
            self::$account->getTable().'_id'=>self::$account->id,
            'status'         =>'open'
        ]);
        $message="";
        return [
            "status"=>200,
            "message"=>self::$messages['contact']['200']
        ];
    }
}