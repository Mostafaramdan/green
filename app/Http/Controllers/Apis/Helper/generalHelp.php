<?php

namespace App\Http\Controllers\Apis\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Http\Controllers\Apis\Controllers\index;
use Illuminate\Support\Str;
use App\Models\admins; 
use App\Models\categories;
use App\Models\app_settings;
use App\Models\emails;
use App\Models\favourites;
use App\Models\images_in_store;
use App\Models\locations;
use App\Models\contacts;
use App\Models\notifications;
use App\Models\notify;
use App\Models\orders;
use App\Models\phones;
use App\Models\providers;
use App\Models\rates;
use App\Models\requests_balance;
use App\Models\servicers_in_orders;
use App\Models\servicers_in_stores;
use App\Models\services;
use App\Models\sessions;
use App\Models\stores;
use App\Models\users;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Hash;
use Validator;
use DB;

class generalHelp extends index
{  
	public static $itemPerPAge=10;
	
	public static function base64_image($image_string,$folderName){
		if(!$image_string)return null;
			// CHECK IF FOLDER EXIST 
			$folderPath="uploads/{$folderName}/";
		if (!file_exists( $folderPath)) 
					mkdir( $folderPath, 0777, true);
			// START MAKE IMAGE

		$path =Str::random(16).'.jpg' ;
		$file = fopen( $folderPath.$path, "wb") ;
		fwrite($file, base64_decode($image_string));
		fclose($file);
		return  "/".$folderPath.$path ;
	}
	public static function uploadPhoto($image,$folderName){

		$folderPath="uploads/{$folderName}//";
		if (!file_exists( $folderPath)) 
					mkdir( $folderPath, 0777, true);
			$img_name = Str::random(30) .now()->timestamp.'.' . $image->getClientOriginalExtension();//generate new name
			$image->move( public_path('uploads/'.$folderName) , $img_name);//move function accept 2para('destnation','filename')
			return '/public/uploads/'.$folderName.$img_name;  				
	}  
		
	public static function chkifSendTwominute($session){
		$now= (Carbon::parse('now')->subMinutes(2))->format('Y-m-d H:i:s');
		return	($session->created_at <= $now)?true:false;
	}

	public static function getAccount($api_token=null,$email=null,$phone=null,$tmpToken=null,$tmp_phone=null,$tmp_email=null){
		$models=self::$providers;
		if($api_token){ 
			$key   = 'api_token';
			$value = $api_token;
		}
		elseif($email){
			$key   = 'email';
			$value = $email;
		}elseif($phone){
			$key   = 'phone';
			$value = $phone;
		}elseif($tmpToken){
			$session=sessions::where('tmp_token',$tmpToken)->first();
			if($session==null)return null;
			foreach($models as $model)
				if($session->$model!=null)
					return $session->$model;
		}elseif($tmp_phone != null){
			$session=sessions::where('tmp_phone',$tmp_phone)->first();
			if($session==null)return null;
			foreach($models as $model)
				if($session->$model!=null)
					return $session->$model;
		}elseif($tmp_email != null){
			$session=sessions::where('tmp_email',$tmp_email)->first();
			if($session==null)return null;
			foreach($models as $model)
				if($session->$model!=null)
					return $session->$model;
		}else{
			return null;
		} 
		for($i=0;$i<count($models);$i++){
			$tableName="\App\Models\\".$models[$i];
			$record=$tableName::all()->where($key,$value)->first();
			if($record != null) break;
		}
		return $record;
	}

	public static function RandomXDigits ($Digits=6) {
			return rand(pow(10, $Digits-1), pow(10, $Digits)-1);
	}

	public static function UniqueRandomXDigits ($Digits=6,$column) {
		
			$code= rand(pow(10, $Digits-1), pow(10, $Digits)-1);
			$models=self::$providers;
			for($i=0;$i<count($models);$i++){ 
				$model='\App\Models\\'.$models[$i];
				if($model::where($column,$code)->count() != 0){
					$code= rand(pow(10, $Digits-1), pow(10, $Digits)-1);
					$i=0;
				}
			}	
			return $code;
	}

	public static function UniqueRandomXChar ($Chars=69,$column,$models=[]){

		$code= Str::random($Chars);
		$models=$models??self::$providers;
		for($i=0;$i<count($models);$i++){ 
			$model='\App\Models\\'.$models[$i];
			if($model::where($column,$code)->count() != 0){
				$code= Str::random($Chars);
				$i=0;
			}
		}	
		return $code;
	}

	public static function HashPassword ($Password) {
			return Hash::make($Password);
	}

	public static function login($record,$password){
		$check=	Hash::check($password,$record->password)  ;
		if($check){
			$record->apiToken=self::UniqueRandomXChar(69,'apiToken');
			$record->save();
		}	
		return $check;
	} 

	public static function changePassword(){
		$account=index::$account;
		$account->password= self::HashPassword(index::$request->newPassword);
		$account->save();
	} 

	public static function updatePassword(){

		if (Hash::check(self::$request->oldPassword ,self::$account->password ) == false) {
			return false;
		}else{
			index::$account->password= self::HashPassword(index::$request->newPassword);
			self::$account->save();
			return true;
		} 
	}

	public static function setAccountByession(){
	
		$key=self::$request->has('phone')?'tmp_phone':'tmp_email';
		$value=self::$request->has('phone')?self::$request->phone:self::$request->email;
		$seeions = $session=sessions::where($key,self::$request->phone)->first();

		if(!$seeions) return null;
		foreach(self::$providers as $provider){
			$account=$seeions->$provider;
			if($account){
				index::$account=$account;
				index::$lang=$account->lang??'ar';
				return true;
			}
		}
	}

	public static function validator ($Request, $Rules, $Messages,$messagesLang){
		$validator = Validator::make($Request, $Rules, $Messages);

		$code=null;
		if ($validator->fails()) {
			$code = $validator->errors()->first();
		}

		$validator = Validator::make($Request, $Rules, $messagesLang);
		if ($validator->fails()) {
			$message = $validator->errors()->first();
		}

		if($code!=null)
			return ['status'=>(int)$code,'message'=>$message];
	}

	public static function showAllErrors ($Request, $Rules, $Messages,$messagesLang){
		$validator = Validator::make($Request, $Rules, $Messages);
		$code=null;
		if ($validator->fails()) {
			$code = $validator->errors();
		}

		$validator = Validator::make($Request, $Rules, $messagesLang);
		if ($validator->fails()) {
			$message = $validator->errors();
		}
		if($code!=null)
			return ['status'=>$code,'message'=>$message];
	}

	public static function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		//$unit = strtoupper($unit);
					
		return ($miles * 1.609344);

	}

	public static function isExpiredSession($session,$minutes){
		$now= (Carbon::parse('now')->subMinutes($minutes));
		return $session->created_at < $now ?true : false ;
	}
	
	public static function sendFCM($pushNotify,$target) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = [
			"to" => $pushNotify->$target->fireBaseToken,
			"notification" => [
				"body" => $pushNotify->notifications['content_'.$pushNotify->$target->lang],
				"title" =>"Aaly",
				// "info" => $pushNotify,
				"icon" => "myicon",
				"sound" => "notify.mp3"
			]
		];
		$fields = json_encode ( $fields );
		$key = $pushNotify->$target->getTable()=="users"?			
			"AAAAbEHuctw:APA91bFExVqVaOu1vSzP8_LIv1V0NqomrMfM8U7xbQ4XOQ5dgoTx59MnJbm3CV8kBna7un-XY5LnmAioJdkGbndJ7czdkYuOvoXxp2X_Ag0A-dykBED479Me7JwCwyZ5YbAUakcyCL0N"
			:
			"AAAAQJrAivQ:APA91bEJK7OygPzhkIWHB6q6Ij6bPhfNkzq1Jkw9n4dmZUMN5ZGtj3HlUJTEu3_g5Cq4Fg1CI5uGL20bcdm7fOXNObIly99I0ueGVH2eilGGMntUDj78RCB1nHUwsYr_n_d91gn8CbLi"
			;
		$headers = [
			'Authorization: key='.$key,
			'Content-Type: application/json'
		];
		$ch = curl_init();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		// if( $pushNotify->$target->fireBaseToken== "dHpoIRKR1sQ:APA91bEIFKSSsNmjyBnUijZc5FughaJBTxyFIPbZJnX5Uf0VIpLLg_J8AS4Q7pugN0FCk8OlNArY4bHqlUG0M9w0viFdsAfva7-t3VVsOS2T9Epew9LcI3jujC7Is4tibdil2pa_VP4z" ){

			// dd($result);
		// }
	}	

	public static function deleteFile($path){
		File::delete($_SERVER['DOCUMENT_ROOT'].$path); // Value is not URL but directory file path
	}
}