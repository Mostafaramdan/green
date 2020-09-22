<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\general_rooms as model;
use App\Models\general_rooms_admins ;
use App\Models\users;
use App\Models\general_rooms_messages;
use App\Http\Controllers\Apis\Controllers\getMessagesInGeneralRooms\getMessagesInGeneralRoomsController;
use App\Http\Controllers\Apis\Resources\objects;

class general_rooms extends Controller
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
        return view('dashboard.general_rooms.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $records= self::$model::orderBy($request->sortBy??"id",$request->sortType??'asc')->get();
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
        $tableInfo= (string) view('dashboard.general_rooms.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request){

        $rules=[
            "name"     =>"required|min:3",
            "description"     =>"required|min:3",
            'regions_id' =>"required|exists:regions,id|",
            "room_image" =>"required_if:id,",
            "background_image" =>"required_if:id,",
            'general_rooms_admins'=>"required"
        ];

        $messages=[
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "description.required" =>"يجب ادخال الاسم",
            "description.min"      =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "regions_id.required" =>"يجب ادخال البلد ",
            "regions_id.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",

            "room_image.required_if"=>"",
           
            "background_image.required_if"=>"",

            'general_rooms_admins.required'=>"يجب إختيار مسؤولين لهذه الغرفة"

        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $createUpdate= [
            'id'=>$request->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'regions_id'=>$request->regions_id,
        ];
        $general_room= self::$model::find($request->id);
        if($request->has('room_image')){
            if($general_room){
                helper::deleteFile($general_room->room_image);
            }
            $createUpdate['room_image']=$request->room_image;
        }
        if($request->has('background_image')){
            if($general_room){
                helper::deleteFile($general_room->background_image);
            }
            $createUpdate['background_image']=$request->background_image;
        }
        $record=self::$model::createUpdate($createUpdate);
        general_rooms_admins::where('general_rooms_id',$record->id)
                            ->delete();
        foreach($request->general_rooms_admins as $users_id){

            general_rooms_admins::createUpdate([
                'users_id'=>$users_id,
                'general_rooms_id'=>$record->id 
                ]);
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
    public static function general_rooms_admins_select($search){
        $users=users::allActive()->filter(function($item) use ($search) {
            if( stripos($item['name'],$search) !== false ||  stripos($item['phone'],$search) !== false)
                return true;
        });
        return view('dashboard.general_rooms.general_room_admin_select',compact('users'));
    }
    public static function getMsssagesInGeneralRooms(Request $request)
    {
        // return $request;
        $records= general_rooms_messages::orderBy('id','DESC')
                                        ->where('general_rooms_id',$request->id)
                                        ->get();
        return [
            'status'=>$records->forPage($request->page+1,config('helperDashboard.itemPerPage'))->count()?200:204,
            'totalPages'=>ceil($records->count()/config('helperDashboard.itemPerPage')),
            'messages'=>objects::ArrayOfObjects($records->forPage($request->page+1,config('helperDashboard.itemPerPage')),'generalRoomMessage'),
        ];

    }
}

