<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class regions extends GeneralModel
{
    protected $table = 'regions',$appends=['country_name'];
    public static function createUpdate($params){

        $record = $params['id']==null ? new self : self::find( $params['id']);
        $record->name_ar =isset($params['name_ar'])?$params['name_ar']: $record->name_ar;
        $record->name_en =isset($params['name_en'])?$params['name_en']: $record->name_en;
        $record->currency =isset($params['currency'])?$params['currency']: $record->currency;
        $record->stateKey =isset($params['stateKey'])?$params['stateKey']: $record->stateKey;
        $record->deliveryPrice =isset($params['deliveryPrice'])?$params['deliveryPrice']: $record->deliveryPrice;
        $record->logo_image =isset($params['logo_image'])?self::$helper::base64_image( $params['logo_image'],'regions'): $record->logo_image;
        $record->regions_id =isset($params['regions_id'])?$params['regions_id']: $record->regions_id;
        isset($params['id'])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();

    }
    public function regions(){   
        return $this->hasMany('\App\Models\regions','regions_id');
    }
    public function region(){   
        return $this->belongsTo('\App\Models\regions','regions_id') ;
    }
    function GetCountryNameAttribute(){
        return $this->region->name_ar??null;
    }
}