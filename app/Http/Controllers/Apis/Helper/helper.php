<?php

namespace App\Http\Controllers\Apis\Helper;
 use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\admins; 
use App\Models\ads;
use App\Models\app_settings;
use App\Models\background_coloring;
use App\Models\background_coloring_given;
use App\Models\blocks;
use App\Models\followers;
use App\Models\friends;
use App\Models\contacts;
use App\Models\general_rooms;
use App\Models\general_rooms_admins;
use App\Models\general_rooms_messages;
use App\Models\logs;
use App\Models\notifications;
use App\Models\notify_users as notify;
use App\Models\private_chats;
use App\Models\private_chats_messages;
use App\Models\private_rooms;
use App\Models\private_rooms_messages;
use App\Models\regions;
use App\Models\reports_types;
use App\Models\report_persons;
use App\Models\roles;
use App\Models\sessions;
use App\Models\stars_and_jewels;
use App\Models\stars_and_jewels_given;
use App\Models\stories;
use App\Models\users;
use App\Models\users_in_general_rooms;
use App\Models\users_in_private_rooms;
use App\Models\verified_request;
use App\Models\visitors;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Hash;
use Validator;
use DB;

class helper extends generalHelp
{
	public static function validateAccount(){
		
		if(self::$account == null ){
			if(self::$request->has('phone')){
				$code=415;
 			}elseif(self::$request->has('email')){
				$code=416;
			}elseif(self::$request->has('tmpToken')){
				$code=417;
			}elseif(self::$request->has('apiToken')){
				$code=403;
			}else{
				return null;
			}
		}else{
			if(self::$account->deleted_at!= null){
				$code= 418;
			}elseif(self::$account->is_active == 0){
				$code=402;
		   }else{
			   return null;
		   }
		}		
		return [
			'status'=>$code,
			'message'=>self::$messages['validateAccount']["{$code}"]
		];   
	}

	public static function newNotify($targets,$message_ar,$message_en,$orderId=null,$type=null,$notificationId=null){
		
		if(!$notificationId){
			$notification   =   notifications::createUpdate([
									'content_ar'=>$message_ar,
									'content_en'=>$message_en,
									'type'    =>$type
									]);
		}
		foreach($targets as $user){
			$notify =   notify::createUpdate([
							'notifications_id'=>$notificationId??$notification->id,
							$user->getTable()."_id" =>$user->users_id??$user->id,
							'orders_id' =>$orderId,
							'is_seen'         =>0,
							'type'            =>$type
						]);
			self::sendFCM( $notify ,'user'); 
		}
		return $notificationId??$notification->id;           
	}	

	// public static function sendSms ($phone , $code)
	// {
	// 	$url = "https://api.twilio.com/2010-04-01/Accounts/ACc0edd5db93c66a177feb43313bde6acb/SMS/Messages.json";
	// 	$from = "+12058501850";
	// 	$to = Str::replaceFirst("00","+",$phone); // twilio trial verified number
	// 	$body = $code;
	// 	$id = "ACc0edd5db93c66a177feb43313bde6acb";
	// 	$token = "6148f7b9d95275482b94a3688dcf2afa";
	// 	$data = array (
	// 		'From' => $from,
	// 		'To' => $to,
	// 		'Body' => $body,
	// 	);
	// 	$post = http_build_query($data);
	// 	$x = curl_init($url );
	// 	curl_setopt($x, CURLOPT_POST, true);
	// 	curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
	// 	curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
	// 	curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	// 	curl_setopt($x, CURLOPT_POSTFIELDS, $post);
	// 	$y = curl_exec($x);
	// 	curl_close($x);

	// }
	public static function sendSms($phone,$code)
    {
        
        $url='https://www.safa-sms.com/api/sendsms.php?username=ahmedm9001&password=$tore@Bravo@123&message='.$code.'&sender=ANYTHING&numbers='.$phone.'&return=xml@Rmduplicated=1';
		self::get_web_page($url);
		// $url = preg_replace("/ /", "%20", $url);
		// file_get_contents($url);

	}
	public static function get_web_page( $url, $cookiesIn = '' ){
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => true,     // Validate SSL Cert
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_COOKIE         => $cookiesIn
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $rough_content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; 
        preg_match_all($pattern, $header_content, $matches); 
        $cookiesOut = implode("; ", $matches['cookie']);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['headers']  = $header_content;
        $header['content'] = $body_content;
        $header['cookies'] = $cookiesOut;
		return $header;
	}
	public static function translateStatus($status)
    {
        
        $array = [
			"ar"=>[
				"waiting"=>" انتظار",
				"accepted"=>"موافقة",
				"onProgress"=>"قيد التنفيذ ",
				"delivered"=>"تم التسليم",
				
			],
			"en"=>[
				"waiting"=>"waiting",
				"accepted"=>"accepted",
				"onProgress"=>"onProgress",
				"delivered"=>"delivered",
			]
		];
		return $array[self::$lang][$status];

    }

}