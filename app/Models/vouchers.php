<?php
namespace App\Models;

class vouchers extends GeneralModel
{
    protected $table = 'vouchers',$appends=["session","type"];

    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->code =isset($params['code'])?$params['code']: $record->code;
        $record->discountPercentage =isset($params['discountPercentage'])?$params['discountPercentage']: $record->discountPercentage;
        $record->maximumDeduction =isset($params['maximumDeduction'])?$params['maximumDeduction']: $record->maximumDeduction;
        $record->timeToUse =isset($params['timeToUse'])?$params['timeToUse']: $record->timeToUse;
        $record->startAt =isset($params['startAt'])?$params['startAt']: $record->startAt;
        $record->endAt =isset($params['endAt'])?$params['endAt']: $record->endAt;
        isset($params['id'])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
}