<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

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
  
   public static function createUpdate ($params)  
    {
      $record = $params['id'] == null ? new self() : self::find($params['id']);
      $record->name = isset($params["name"])? $params["name"]: $record->name;
      $record->email = isset($params["email"])? $params["email"]: $record->email;
      $record->phone  = isset($params["phone"])? $params["phone"]: $record->phone ;
      $record->permissions  = isset($params["permissions"])? $params["permissions"]: $record->permissions ;
      $record->image =isset($params['image'])?helper::base64_image( $params['image'],'admins'): $record->image;
      $record->isSuperAdmin  = isset($params["isSuperAdmin"])? $params["isSuperAdmin"]: $record->isSuperAdmin ;
      $record->password = isset($params["password"])? helper::HashPassword($params['password']): $record->password;
      isset($params["id"])?:$record->created_at = date("Y-m-d H:i:s");
      $record->save();

    }
     public function stores(){
            return $this->hasMany('\App\stores','admins_id');
      }
    

}
