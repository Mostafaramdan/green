<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\app_settings as model;
use App\Models\emails ;
use App\Models\phones ;
use  App\Http\Controllers\Apis\Controllers\index;

class app_settings extends Controller
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
    $record= self::$model::first();
    if(!$record){  
        $record =
            self::$model::createUpdate([
                'id'=>$recor->id??null,
                'about_us_ar'=>" . ",
                "about_us_en"=>" . ",
                "policy_terms_ar"=>" .",
                "policy_terms_en"=>" .",
                "fees"=>1,
                "distance"=>1
            ]);
    }
    return view('dashboard.app_settings.index',compact("record"));
}   

public static function indexPageing(Request $request)
{
    $record= self::$model::first();
    $tableInfo= (string) view('dashboard.app_settings.tableInfo',compact('record'));
    return ['paging'=>0,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){

    $record= self::$model::first();
    $record=    self::$model::createUpdate([
            'id'=>$record->id,
            'about_us_ar'=>$request->about_us_ar,
            "about_us_en"=>$request->about_us_en,
            "policy_terms_ar"=>$request->policy_terms_ar,
            "policy_terms_en"=>$request->policy_terms_en,
            "fees"=>$request->fees,
            "distance"=>$request->distance
        ]);

    if($request->phones){
        phones::where('app_settings_id',$record->id)->delete();
        foreach(explode(",",$request->phones) as $phone){
            phones::createUpdate([
                "phone"=>$phone,
                "app_settings_id"=>$record->id
            ]);
        }
    }
    if($request->emails){
        emails::where('app_settings_id',$record->id)->delete();
        foreach(explode(",",$request->emails) as $email){
            emails::createUpdate([
                "email"=>$email,
                "app_settings_id"=>$record->id
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

