<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\appInfo as model;
use App\Models\phones;
use App\Models\emails;

class appInfo extends Controller
{
public static $model;
function __construct(Request $request)
{
    self::$model=model::class;
}
public static function index()
{
    $record= self::$model::first();
    if(!$record){
        $record =
            self::$model::createUpdate([
                'welcomeAr'=>$recor->id??null,
                'welcomeEn'=>0,
                "aboutAr"=>"@mail.com",
                "aboutEn"=>" . ",
                "policyAr"=>" .",
                "policyEn"=>5,
                "termsAr"=>1,
                "termsEn"=>100,
                "userFees"=>1,
                "driverFees"=>1,
                "fees"=>1,
                "radius"=>1
            ]);
    }
    return view('dashboard.appinfo.index',compact("record"));
}   

public static function indexPageing(Request $request)
{
    $record= self::$model::first();
    $tableInfo= (string) view('dashboard.appinfo.tableInfo',compact('record'));
    return ['paging'=>0,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request)
{
    $record= self::$model::first();
    self::$model::createUpdate([
        'id'        =>$record->id,
        'welcomeAr' =>$request->welcomeAr,
        'welcomeEn' =>$request->welcomeEn,
        "aboutAr"   =>$request->aboutAr,
        "aboutEn"   =>$request->aboutEn,
        "policyAr"  =>$request->policyAr,
        "policyEn"  =>$request->policyEn,
        "privacyAr"   =>$request->privacyAr,
        "privacyEn"   =>$request->privacyEn,
        "userFees"  =>$request->userFees,
        "driverFees"=>$request->driverFees,
        "fees"      =>$request->fees,
        "radius"      =>$request->radius,
    ]);
    if($request->phones){
        phones::where('appInfo_id',$record->id)->delete();
        foreach(explode(",",$request->phones) as $phone){
            phones::createUpdate([
                "phone"=>$phone,
                "appInfo_id"=>$record->id
            ]);
        }
    }
    if($request->emails){
        emails::where('appInfo_id',$record->id)->delete();
        foreach(explode(",",$request->emails) as $email){
            emails::createUpdate([
                "email"=>$email,
                "appInfo_id"=>$record->id
            ]);
        }
    }
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