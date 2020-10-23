<?php
namespace App\Http\Controllers\Apis\Controllers\getRegions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Controllers\Apis\Resources\objects;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Models\regions;

class getRegionsController extends index
{
    public static function api(){

        $records=  regions::allActive()->where('regions_id',null)->sortBy('id');
        return [
            'status'=>$records->count()?200:204,
            'totalPages'=>ceil($records->count()/self::$itemPerPage),
            'countries'=>objects::ArrayOfObjects($records,'region'),
        ];
    }
}