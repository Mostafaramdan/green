<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\ads as model;
use  App\Http\Controllers\Apis\Controllers\index;

class ads extends Controller
{
public static $model;
function __construct(Request $request)
{
    index::$request=new Request();
    index::$lang="ar";
    self::$model=model::class;
}
public static function index()
{
    $records= self::$model::all();
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= 1;
    $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
    return view('dashboard.ads.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
  $sort=$request->sortType??'sortBy';
  $records= self::$model::all()->$sort($request->sortBy??"id");   
   if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                return stripos($item['id'],$search) !== false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.ads.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "action"   =>"required|url",
        'end_date' =>"required|after:".date("Y-m-d"),
        "start_date"=>"required|before:end_date",
        'image' =>"required_if:id,",
    ];

    $messages=[
    ];

    $messagesAr=[
        "action.required"     =>"يجب ادخال مكان توجيه الاعلان ",
        "action.url"          =>"يجب ادخال مكان توجيه الاعلان  بشكل صحيح . يجب ان يكون رابط يعمل  ",

        "end_date.required" =>"يجب ادخال ميعاد انتهاء الاعلان",
        "end_date.after"       =>"يجب ادخال ميعاد انتهاء الاعلان بعد تاريخ اليوم",
        
        "start_date.required" =>"يجب ادخال ميعاد بداية الاعلان",
        "start_date.after"       =>"يجب ادخال ميعاد بداية الاعلان بعد تاريخ النهاية",
        
        "image.required_if" =>"يجب ادخال الصورة ",
    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'id'=>$request->id,
        'action'=>$request->action,
        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date,
        'image'=>$request->image,  
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

