<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\notifications as model;
use App\Models\notify  ;
use App\Models\users  ;
use App\Models\providers  ;
use  App\Http\Controllers\Apis\Controllers\index;

class notifications extends Controller
{
public static $model;
function __construct(Request $request)
{
    self::$model=model::class;
}
public static function index()
{
    $records= self::$model::all()->where('type','dashboard');
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= 1;
    $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
    return view('dashboard.notifications.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
    $records= self::$model::orderBy($request->sortBy??"id",$request->sortType??'asc')->where('type','dashboard')->get();
    if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                if( stripos($item['content_ar'],$search) !== false || stripos($item['content_en'],$search) !== false)
                    return true;
                return false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.notifications.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request)
{
    index::$request=new Request();
    index::$lang="ar";
    $rules=[
        "content_ar"     =>"required|min:3",
        "content_en"     =>"required|min:3",
    ];

    $messages=[
    ];

    $messagesAr=[

        "content_ar.required"     =>"يجب ادخال المحتوي بالعربي",
        "content_ar.min"          =>"يجب ان لا يقل المحتوي بالعربي عن 3 حروف ",

        "content_en.required"     =>"يجب ادخال المحتوي بالإنجليزي",
        "content_en.min"          =>"يجب ان لا يقل المحتوي بالإنجليزي عن 3 حروف ",
    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
    if ($Validation !== null) {    return $Validation;    }    
    
    //create Notification 
    if($request->id){
        self::$model::where('id',$request->id)->delete();
    }
    if(!$request->checkType){
        $table='\App\Models\\'.$request->users_type."s";
        $users = $table::allActive();
        $users?helper::newNotify($users,$request->content_ar,$request->content_en,null,'dashboard'):null;            
    }else{
        $notificationId = helper::newNotify(users::allActive(),$request->content_ar,$request->content_en,null,'dashboard');        
        helper::newNotify(providers::allActive(),$request->content_ar,$request->content_en,null,'dashboard',$notificationId);            

    }
    $message=$request->id?"edited successfully":'added successfully';
    
    return response()->json(['status'=>200,'message'=>$message]);
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

