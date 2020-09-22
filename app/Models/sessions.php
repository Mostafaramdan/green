<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sessions extends GeneralModel
{
    protected $table = 'sessions',$appends=['model'];

    public static function createUpdate($params){

        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->tmp_token = isset($params['tmp_token']) ? $params['tmp_token']: $record->tmp_token;
        // $record->tmp_email = isset( $params['tmp_email'])? $params['tmp_email']: $record->tmp_email;
        $record->tmp_phone = isset( $params['tmp_phone'])? $params['tmp_phone']: $record->tmp_phone;
        $record->code =isset( $params['code'])? $params['code']:$record->code;
        $record->users_id  = $params['users_id'] ?? $record->users_id ;
        $record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function users(){
        return $this->belongsTo('\App\Models\users','users_id');
    }
}