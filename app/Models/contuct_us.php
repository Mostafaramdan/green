<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contuct_us extends GeneralModel
{
    protected $table = 'contuct_us',$appends=['name','phone','email'];

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->name = isset($params["name"])? $params["name"]: $record->name;
        $record->phone = isset($params["phone"])? $params["phone"]: $record->phone;
        $record->message = isset($params["message"])? $params["message"]: $record->message;
        $record->status = isset($params["status"])? $params["status"]: $record->status;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        $record->providers_id = isset($params["providers_id"])? $params["providers_id"]: $record->providers_id;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function users()
    {
        return $this->belongsTo(users::class,"users_id");
    }
    public function providers()
    {
        return $this->belongsTo(providers::class,"providers_id");
    }
    function GetNameAttribute(){
        return $this->users?$this->users->name:$this->providers->name;
    }
    function GetPhoneAttribute(){
        return $this->users?$this->users->phone:$this->providers->phone;
    }
    function GetEmailAttribute(){
        return $this->users?$this->users->email:$this->providers->email;
    }
}
