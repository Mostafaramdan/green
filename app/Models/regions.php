<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
class regions extends GeneralModel
{
    protected $table = 'regions';
    

    public static function createUpdate($params){

        $record = $params['id']==null ? new self : self::find( $params['id']);
        $record->name_ar =isset($params['name_ar'])?$params['name_ar']: $record->name_ar;
        $record->name_en =isset($params['name_en'])?$params['name_en']: $record->name_en;
        $record->currency =isset($params['currency'])?$params['currency']: $record->currency;
        $record->deliveryPrice =isset($params['deliveryPrice'])?$params['deliveryPrice']: $record->deliveryPrice;
        $record->logo =isset($params['logo'])?self::$helper::base64_logo( $params['logo'],'regions'): $record->logo;
        $record->regions_id	= $params['regions_id'] ?? $record->regions_id	;
        $record->created_at= $record->created_at?? helper::dateTime();

    }

    public function regions(){   
        return $this->hasMany('\App\Models\regions','regions_id') ;
    }
    public function region(){   
        return $this->belongsTo('\App\Models\regions','regions_id') ;
    }
}
