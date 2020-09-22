<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\private_rooms as model;
use App\Models\users;
use App\Models\private_rooms_messages;
use App\Http\Controllers\Apis\Controllers\getMessagesInGeneralRooms\getMessagesInGeneralRoomsController;
use App\Http\Controllers\Apis\Resources\objects;

class private_rooms extends Controller
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
        return view('dashboard.private_rooms.index',compact("records","totalPages",'currentPage'));
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
        $tableInfo= (string) view('dashboard.private_rooms.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request)
    {
        $rules=[
            "name"     =>"required|min:3",
            "description"     =>"required|min:3",
            'owners_id' =>"required|exists:users,id",
            "room_image" =>"required_if:id,",
            "background_image" =>"required_if:id,",
        ];

        $messages=[
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "description.required" =>"يجب ادخال الاسم",
            "description.min"      =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "owners_id.required" =>"يجب ادخال المسؤول عن هذه الغرفة ",
            "owners_id.exists"   =>"هذا الرقم غير مسجل في قاعدة البيانات",

            "room_image.required_if"=>"يجب إدخال صورة الغرفة ",
           
            "background_image.required_if"=>"يجب إدخال صورة الخلفية للغرفة",
        ];

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }    
        $createUpdate= [
            'id'=>$request->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'owners_id'=>$request->owners_id,
            'is_active'=>1
        ];
        $private_room= self::$model::find($request->id);
        if($request->has('room_image')){
            if($private_room){
                helper::deleteFile($private_room->room_image);
            }
            $createUpdate['room_img']=$request->room_image;
        }
        if($request->has('background_image')){
            if($private_room){
                helper::deleteFile($private_room->background_image);
            }
            $createUpdate['background_img']=$request->background_image;
        }
        $record=self::$model::createUpdate($createUpdate);

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

    public static function private_rooms_admins_select ($search){
        $users=users::allActive()->filter(function($item) use ($search) {
            if( stripos($item['name'],$search) !== false ||  stripos($item['phone'],$search) !== false)
                return true;
        });
        return view('dashboard.private_rooms.private_room_admin_select',compact('users'));
    }
    public static function getMsssagesInPrivateRooms(Request $request)
    {
        // return $request;
        $records= private_rooms_messages::orderBy('id','DESC')
                                        ->where('private_rooms_id',$request->id)
                                        ->get();
        return [
            'status'=>$records->forPage($request->page+1,config('helperDashboard.itemPerPage'))->count()?200:204,
            'totalPages'=>ceil($records->count()/config('helperDashboard.itemPerPage')),
            'messages'=>$records->forPage($request->page+1,config('helperDashboard.itemPerPage'))->flatten(1),
        ];

    }


}

