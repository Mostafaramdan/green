<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class dashboard
{
    
    public function handle($request, Closure $next){
       
        if(Auth::guard('dashboard')->check()  ) { 
            if(Auth::guard('dashboard')->user()->isSuperAdmin){
                return $next($request);
            }else{
                return $next($request);
                if(explode( '/' ,url()->previous())[4] == 'login'){
                    return $next($request);
                }else{
                    $currentRequest= \Request::segment(2);
                    $permissionsOfThis= (json_decode(Auth::guard('dashboard')->user()->permissions , true))[$currentRequest];
                    $permissionsName= [
                        null=>'view',
                        'createUpdate'=>$request->id?$permissionsOfThis['edit']:$permissionsOfThis['add'],
                        'delete'=>$permissionsOfThis["delete"],
                    ]; 
                    if(!isset($permissionsName[\Request::segment(3)]) ||  $permissionsName[\Request::segment(3)] ){
                            return $next($request);
                    }else{
                        abort(403);
                    }
                }
            return $next($request);
            }   
        }else{     
          return redirect()->route('dashboard.login.index');
        }
    }
}
