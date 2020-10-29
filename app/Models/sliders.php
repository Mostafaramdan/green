<?php

namespace App\Models;

use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Database\Eloquent\Model;

class sliders extends GeneralModel
{
    protected $table = 'sliders';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->startAt = isset($params["startAt"])? $params["startAt"]: $record->startAt;
        $record->endAt = isset($params["endAt"])? $params["endAt"]: $record->endAt;
        $record->url = isset($params["url"])? $params["url"]: $record->url;
        $record->image =isset($params['image'])?helper::base64_image( $params['image'],'sliders'): $record->image;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
}
