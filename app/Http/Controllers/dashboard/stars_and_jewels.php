<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;
use App\Models\stars_and_jewels as model;

class stars_and_jewels extends Controller
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
    return view('dashboard.stars_and_jewels.index',compact("records","totalPages",'currentPage'));
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
    $tableInfo= (string) view('dashboard.stars_and_jewels.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "color"     =>"required|min:3",
        'image' =>"required_if:id,",
        "type" =>"required",
    ];

    $messages=[
    ];

    $messagesAr=[

        "color.required"     =>"يجب ادخال اللون",

        "type.required" =>"يجب ادخال النوع ",
        "type.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",

        "image.required_if" =>"يجب ادخال الصورة ",

    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'id'=>$request->id,
        'color'=>$request->color,
        'type'=>$request->type,
        'image'=>$request->image,
        'is_active'=>1,
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

