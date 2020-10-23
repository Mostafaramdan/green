<?php
namespace App\Http\Controllers\Apis\Controllers\getProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\products;

class getProductsController extends index
{
    public static function api()
    {
        $records=  products::allActive()->where('categories_id',self::$request->categoryId)->where('discount',null);;
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "products"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"product"),
        ];
    }
}