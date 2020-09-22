<?php

namespace App\Http\Controllers\Apis\Controllers\changeLang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\users;
use App\Models\providers;

class changeLangController extends index
{
    public static function api(){
        $type='App\Models\\'.self::$account->getTable();
        $type::createUpdate([
           'id'=>self::$account->id,
           'lang'=>self::$request->lang
        ]);
        return [
            "status"=>200,
        ];
    }
}