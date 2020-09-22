<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
  class admins extends Authenticatable
  {
    protected $table = 'admins';

    public $timestamps=false;
   

   
    public function setAttribute($key, $value)
  {
    $isRememberTokenAttribute = $key == $this->getRememberTokenName();
    if (!$isRememberTokenAttribute)
    {
      parent::setAttribute($key, $value);
    }
  }
  
   public static function createUpdate ($Param)  
    {
      $record = $Param['id'] == null ? new self() : self::find($Param['id']);
      $record->name = isset($params["name"])? $params["name"]: $record->name;
      $record->email = isset($params["email"])? $params["email"]: $record->email;
      $record->phone  = isset($params["phone"])? $params["phone"]: $record->phone ;
      $record->image =isset($params['image'])?self::$helper::base64_image( $params['image'],'admins'): $record->image;
      $record->isSuperAdmin  = isset($params["isSuperAdmin"])? $params["isSuperAdmin"]: $record->isSuperAdmin ;
      $record->password = isset($params["password"])? self::$helper::HashPassword($Param['password']): $record->password;
      !isset($Param['id']) ?$record->created_at=helper::MysqlDateTime() :null;
      $record->save();

    }
     public function stores(){
            return $this->hasMany('\App\stores','admins_id');
      }
    

}
