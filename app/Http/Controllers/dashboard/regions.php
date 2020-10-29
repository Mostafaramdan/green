<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\regions as model;

class regions extends Controller
{
public static $model;
function __construct(Request $request)
{
    self::$model=model::class;
}
public static function index()
{
    $records= self::$model::all();
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= 1;
    $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
    return view('dashboard.regions.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
  $sort=$request->sortType??'sortBy';
  $records= self::$model::all()->$sort($request->sortBy??"id",);    if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                return stripos($item['name'],$search) !== false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.regions.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){

    $rules=[
        "name_ar"     =>"required|min:3",
        "name_en"     =>"required|min:3",
        "currency"     =>"required",
        "stateKey"     =>"required",
        "deliveryPrice"     =>"required",
        "logo_image"     =>"required",
        'regions_id' =>"required_if:check,|not_in:".$request->id,
    ];

    $messages=[
    ];

    $messagesAr=[

        "name_ar.required"     =>"يجب ادخال الاسم بالعربي",
        "name_ar.min"          =>"يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

        "name_en.required"     =>"يجب ادخال الاسم بالانجليزية",
        "name_en.min"          =>"يجب ان لا يقل الاسم بالانجليزية عن 3 حروف ",

        "currency.required"     =>"يجب ادخال العملة ",

        "stateKey.required"     =>"يجب ادخال رقم الدولة",

        "deliveryPrice.required"     =>"يجب ادخال  سعر التوصيل",

        "logo_image.required"     =>"يجب ادخال اللوجو ",

        "regions_id.required_if" =>"يجب ادخال البلد ",
        "regions_id.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",
        "regions_id.not_in"   =>"لا يمكن اختيار البلد مع نفس المدينة",

    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'id'=>$request->id,
        'name_ar'=>$request->name_ar,
        'name_en'=>$request->name_en,
        'regions_id'=>$request->regions_id,
        'currency'=>$request->currency,
        'stateKey'=>$request->stateKey,
        'deliveryPrice'=>$request->deliveryPrice,
        'logo_image'=>$request->logo_image,
    ]);

    $message=$request->id?"edited successfully":'added successfully';
    
    return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
}

public static function getRecord($id)
{
    return  self::$model::find($id);
}
public static function check($type, $id)
{
    $record= self::$model::find($id);
    if($record->$type){
        $action="false";
        $record->$type=0;
    }else{
        $action="true";
        $record->$type=1;
    }
    $record->save();
    return response()->json(['status',200,'action'=>$action]);
}
public static function delete($id)
{
    $record= self::$model::find($id);
    $record->delete();
    return response()->json(['status'=>200]);
}
}

