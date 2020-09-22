<?php
namespace App\Http\Controllers\Apis\Controllers\getSliders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\sliders;

class getSlidersController extends index
{
    public static function api()
    {
        $records=  sliders::allActive()
                          ->where('startAt','<=' , date('Y-m-d'))
                          ->where('endAt','>' , date('Y-m-d'));
        return [
            "status"=>$records->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "sliders"=>objects::ArrayOfObjects($records,"slider"),
        ];
    }
}