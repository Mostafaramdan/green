<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contact_us extends GeneralModel
{
    protected $table = 'contact_us',$appends=['name','phone','email'];

    public static function createUpdate($params)
    {
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->name = isset($params["name"])? $params["name"]: $record->name;
        $record->phone = isset($params["phone"])? $params["phone"]: $record->phone;
        $record->message = isset($params["message"])? $params["message"]: $record->message;
        $record->users_id = isset($params["users_id"])? $params["users_id"]: $record->users_id;
        isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function users()
    {
        return $this->belongsTo(users::class,"users_id");
    }
    function GetNameAttribute(){
        return $this->users?$this->users->name:$this->attributes['name']??null;
    }
    function GetPhoneAttribute(){
        return $this->users?$this->users->phone:$this->attributes['phone']??null;
    }
    function GetEmailAttribute(){
        return $this->users?$this->users->email:$this->attributes['email']??null;
    }
}
