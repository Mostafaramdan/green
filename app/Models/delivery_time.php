<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class delivery_time extends GeneralModel
{
    protected $table = 'delivery_time';
    public $timestamps=false;

    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name_ar =isset($params['name_ar'])?$params['name_ar']: $record->name_ar;
        $record->name_en =isset($params['name_en'])?$params['name_en']: $record->name_en;
        $record->from =isset($params['from'])?$params['from']: $record->from;
        $record->to =isset($params['to'])?$params['to']: $record->to;
        $record->save();
        return $record;
    }
}