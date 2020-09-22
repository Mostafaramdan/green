<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\roles as model;

class roles extends Controller
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
    return view('dashboard.roles.index',compact("records","totalPages",'currentPage'));
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
    $tableInfo= (string) view('dashboard.roles.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "name"     =>"required|min:3",
        "email"    =>"required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email",
        "phone"    =>"required_if:email,|numeric|between:100000000000,99999999999999999999|unique:users,phone",
        'regionId' =>"required|exists:regions,id|",
        "password" =>"required|min:6",
    ];

    $messages=[
    ];

    $messagesAr=[

        "name.required"     =>"يجب ادخال الاسم",
        "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

        "email.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتوني",
        "email.regex"       =>"يجب ادخال البريد الالكتروني بشكل صحيح",
        "email.min"         =>"يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
        "email.unique"      =>"هذا البريد مسجل مسبقا",

        "phone.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
        "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
        "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
        "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
        
        "regionId.required" =>"يجب ادخال البلد ",
        "regionId.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",

        "password.required" =>"يجب ادخال الرقم السري",
        "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'name'=>$request->name,
        'regions_id'=>$request->regionId,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'password'=>$request->password,
        'image'=>$request->image,  
        'is_android'=>1, 
        'is_online'=>0, 
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

