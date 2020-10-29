<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\categories as model;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Models\images ;
use App\Models\offers ;

class categories extends Controller
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
    return view('dashboard.categories.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
  $sort=$request->sortType??'sortBy';
  $records= self::$model::all()->$sort($request->sortBy??"id");   
   if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                return stripos($item['name'],$search) !== false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.categories.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "name_ar"     =>"required|min:3",
        "name_en"     =>"required|min:3",
    ];
    if($request->has('offer')){
        $rules=[
            "discountPercentage" =>"required|numeric|min:1|max:99",
            "maximumDeduction"   =>"required|numeric|min:1",
            "startAt"            =>"required|after:".date("Y-m-d H:i:s"),
            "endAt"              =>"required|after:startAt",
        ];
    }

    $messages=[
    ];

    $messagesAr=[

        "name_ar.required"     =>"يجب ادخال الاسم بالعربي",
        "name_ar.min"          =>"يجب ان لا يقل الاسم بالعربي عن 3 حروف ",

        "name_en.required"     =>"يجب ادخال الاسم بالإنجليزية",
        "name_en.min"          =>"يجب ان لا يقل الاسم بالإنجليزية عن 3 حروف ",

        "discountPercentage.required"         =>"يجب ادخال نسبة الخصم ",
        "discountPercentage.min"              =>"يجب ادخال  نسبة الخصم بشكل صحيح ",
        "discountPercentage.max"              =>"يجب ادخال  نسبة الخصم بشكل صحيح ",

        "maximumDeduction.required" =>"يجب ادخال اكبر رقم للخصم   ",
        "maximumDeduction.min"      =>" يجب ادخال اكبر رقم للخصم بشكل صحيح   ",

        "startAt.required"     =>"يجب ادخال تاريخ البداية  ",
        "startAt.after"     =>" يجب ادخال تاريخ البداية بعد الوقت الحالي  ",

        "endAt.required"     =>"يجب ادخال تاريخ النهاية  ",
        "endAt.after"     =>" يجب ادخال تاريخ النهاية بعد تاريخ البداية   ",



    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
    if ($Validation !== null) {    return $Validation;    }    
    $record= self::$model::createUpdate([
        'id'=>$request->id,
        'name_ar'=>$request->name_ar,
        'name_en'=>$request->name_en,
        'categories_id'=>$request->categories_id,
        'is_active'=>1
    ]);
    $newOffer= true;
    if($request->has('offer')){
        if($record->offer){
            $offer= $record->offer;
            if($offer->discount == $request->discount && 
                $offer->maximumDeduction == $request->maximumDeduction && 
                $offer->startAt == $request->startAt && 
                $offer->endAt == $request->endAt 
            ){
                $newOffer=false;
            }else{
                $offer->is_active= 0;
                $offer->save();
                $newOffer=true;
            }
        }else{
            $newOffer=true;
        }
        if ($newOffer){
            offers::createUpdate([
                'categories_id'=>$record->id,
                "discountPercentage"=>$request->discountPercentage,
                "maximumDeduction"=>$request->maximumDeduction,
                "startAt"=>$request->startAt,
                "endAt"=>$request->endAt,
            ]);

        }
    }

    $message=$request->id?"edited successfully":'added successfully';
    
    return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
}

public static function getRecord($id)
{
    index::$request=new Request();
    index::$lang="ar";
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

