<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Controllers\index;

class notifications extends GeneralModel
{
    protected $table = 'notifications';
    public static function createUpdate($params){

        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->content_ar = isset($params['content_ar'])?$params['content_ar']: $record->content_ar;
        $record->content_en = isset($params['content_en'])?$params['content_en']: $record->content_en;
        $record->orders_id = isset($params['orders_id'])?$params['orders_id']: $record->orders_id;
        isset($params['id'])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
   
    public function notify(){
        return $this->hasMany(notify_users::class,'notifications_id');
    }
}