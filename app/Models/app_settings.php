<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Controllers\index;

class app_settings extends GeneralModel
{
   protected $table = 'app_settings';
   public static function createUpdate($params)
   {
      $record= isset($params["id"])? self::find($params["id"]) :new self();
      $record->aboutUs_ar = isset($params["aboutUs_ar"])? $params["aboutUs_ar"]: $record->aboutUs_ar;
      $record->aboutUs_en = isset($params["aboutUs_en"])? $params["aboutUs_en"]: $record->aboutUs_en;
      $record->policyTerms_ar = isset($params["policyTerms_ar"])? $params["policyTerms_ar"]: $record->policyTerms_ar;
      $record->policyTerms_en = isset($params["policyTerms_en"])? $params["policyTerms_en"]: $record->policyTerms_en;
      $record->email = isset($params["email"])? $params["email"]: $record->email;
      $record->phone = isset($params["phone"])? $params["phone"]: $record->phone;
      $record->daysToDelivery = isset($params["daysToDelivery"])? $params["daysToDelivery"]: $record->daysToDelivery;
      $record->save();
      return $record;
    }

}
