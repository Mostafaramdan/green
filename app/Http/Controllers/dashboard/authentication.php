<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth  ;
use App\Models\admins;
use Session as flash;
use Hash;

class authentication extends Controller
{
    public static function index(Request $request){
        if(Auth::guard('dashboard')->check())
            return redirect()->route('dashboard.users.index');
        return view('dashboard.auth.login');
    }
    public static function login(Request $request){
       
        $rules =[
            'email'       =>'required|email|exists:admins,email',
            'password'    =>"required|",
        ];
        $messages=[
            "email.required"=>"يجب إدخال البريد الإلكتروني",
            "email.regex"=>"يجب إدخال البريد الإلكتروني بشكل صحيح",
            "email.exists"=>"البريد الإلكتروني غير صحيح",

            "password.required"  =>"يجب إدخال الرقم السري",
        ];
        $request->validate($rules, $messages);

        $admin = admins::where('email',$request->email)->first();

        if(Hash::check($request->password ,$admin->password )){
            \Auth::guard('dashboard')->login($admin); 
            return redirect()->route('dashboard.statistics.index');
        }else{
            flash::flash('incorrectPassword','كلمة مرور خاطئة');
            return back();
        }
    }
    public static function logout(Request $request){
        
        \Auth::guard('dashboard')->logout(); 
        return redirect()->route('dashboard.login.index');
}

}
