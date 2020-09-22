<?php

namespace App\Models;
use App\Http\Controllers\Apis\Controllers\index;
use Illuminate\Database\Eloquent\Model;

class notify_users extends GeneralModel
{
    protected $table = 'notify_users';

    public static function createUpdate($params){

        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->notifications_id = $params['notifications_id']?? $record->notifications_id;
        $record->isSeen = isset($params['isSeen'])? $params['isSeen']: $record->isSeen;
        $record->users_id = isset($params['users_id'])? $params['users_id']: $record->users_id;
        isset($params['id'])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function notification (){
        return $this->belongsTo(notifications::class,'notifications_id');
    }
    public function user (){
        return $this->belongsTo(users::class,'users_id');
    }
    public function order (){
        return $this->belongsTo(orders::class,'orders_id');
    }
}