<?php

namespace App\Http\Controllers\Apis\Controllers;

use App\Http\Controllers\Apis\Helper\helper ;
use App\Models\users;
use App\Models\GeneralModel;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class index extends Controller
{
    public static   $account,$request,$secondAccount,$isSendMessage=false,$itemPerPage=20,
                    $className,$classRules,$lang,$providers=['users'],$messages,$messagesAll;
    
    function __construct(Request $request){

        if($request->has('phone'))     
            $request->offsetSet('phone',Str::replaceFirst('+', '00',$request->phone ));
       
        self::$request=$request;
        self::setAccount($request);
        self::setSecondAccount();
        self::setClassName();
        self::setClassRules();
        self::setLang();
        $messages=include "lang.php";
        self::$messages=$messages[self::$lang];
        self::$messagesAll=$messages;
    }
    
    public static function index(){
        return response()->json( self::$classRules::rules()??self::$className::api() );
    }

    public static function setAccount($request){
        
        if($request->has('apiToken')){
            self::$account=helper::getAccount($request->apiToken,null,null);     
        }
        elseif($request->has('phone')){
            self::$account=helper::getAccount(null,null,$request->phone);
        }
        elseif($request->has('email')){
            self::$account=helper::getAccount(null,$request->email,null);          
        }
        elseif($request->has('tmpToken')){
            self::$account=helper::getAccount(null,null,null,$request->tmpToken);          
        }
    }

    public static function setSecondAccount(){
        if(self::$request->has('userId')){
            self::$secondAccount =  users::find(self::$request->userId); 
        }elseif(self::$request->has('providerId')){
            self::$secondAccount =  providers::find(self::$request->providerId); 
        }else{  
            self::$secondAccount==null;
        }
    }

    public static function setClassName(){
        $requestName=self::$request->segment(2);
        self::$className= 'App\Http\Controllers\Apis\Controllers\\'.$requestName.'\\'.$requestName.'Controller';
    }

    public static function setClassRules(){
        $requestName=self::$request->segment(2);
        self::$classRules= 'App\Http\Controllers\Apis\Controllers\\'.$requestName.'\\'.$requestName.'Rules';
    }

    
    public static function setLang(){
    
        if(self::$request->has('lang')&& in_array(self::$request->lang,['ar','en'])){
            self::$lang=self::$request->lang;
        }elseif(self::$account && self::$account->lang ){
            self::$lang=self::$account->lang;
        }else{
              self::$lang='ar';
        }
    }
}