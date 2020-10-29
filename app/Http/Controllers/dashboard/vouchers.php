<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\vouchers as model;

class vouchers extends Controller
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
        return view('dashboard.vouchers.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
      $sort=$request->sortType??'sortBy';
      $records= self::$model::all()->$sort($request->sortBy??"id",);    if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    return stripos($item['code'],$search) !== false;
                });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage>0?$request->currentPage:1;
        $records=$records->forpage($currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.vouchers.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "discountPercentage"  =>"required",
            "maximumDeduction"    =>"required",
            "timeToUse"           =>"required",
            "startAt"             =>"required|after:".date("Y-m-d H:i"),
            "endAt"               =>"required|after:startAt",
        ];

        $messages=[
        ];

        $messagesAr=[

            "discountPercentage.required"     =>"يجب ادخال نسبة الخصم",
            "maximumDeduction.required"     =>"يجب ادخال اقصي رقم للخصم",
            "timeToUse.required"     =>"يجب ادخال عدد مرات الاستخدام",
            "startAt.required"     =>"يجب ادخال تاريخ البداية",
            "startAt.after"     =>"  تاريخ البداية يجب ان يكود بداية من ".date("Y-m-d H:i"),
            "endAt.required"     =>"يجب ادخال تاريخ النهاية",
            "endAt.after"     =>"  تاريخ البداية يجب ان يكود بعد تاريخ البداية ",

        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'discountPercentage'=>$request->discountPercentage,
            'maximumDeduction'=>$request->maximumDeduction,
            'timeToUse'=>$request->timeToUse,
            'startAt'=>$request->startAt,
            'endAt'=>$request->endAt,
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

