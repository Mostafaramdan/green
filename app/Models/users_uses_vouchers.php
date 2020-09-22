<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class users_uses_vouchers extends GeneralModel
{
    protected $table = 'users_uses_vouchers';

    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->users_id =isset($params['users_id'])?$params['users_id']: $record->users_id;
        $record->vouchers_id =isset($params['vouchers_id'])?$params['vouchers_id']: $record->vouchers_id;
        $record->save();
        return $record;
    }
}