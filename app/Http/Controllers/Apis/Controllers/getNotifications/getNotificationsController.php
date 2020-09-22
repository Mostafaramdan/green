<?php
namespace App\Http\Controllers\Apis\Controllers\getNotifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\notify_users;

class getNotificationsController extends index
{
    public static function api()
    {
        $records=  notify_users::where('users_id',self::$account->id)->orderBy('id','DESC')->get();
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "notifications"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"notification"),
        ];
    }
}