<?php
namespace App\Http\Controllers\Apis\Controllers\getCategories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\categories;

class getCategoriesController extends index
{
    public static function api()
    {
        $records=  categories::allActive();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "categories"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"category"),
        ];
    }
}