<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function loginPost(Request $request){

        $user  = User::where('Username', $request->Username)->first();

        if ($user) {
            if(explode("==:",$user->Password)[1]==$request->Password && $user) {
                // Auth::loginUsingId($udata->ID);
                // // -- OR -- //
                if(in_array($user->RebateRole,Helper::$rebateRole['auth_login'])){
    
                    Auth::login($user);
    
                    return redirect()->route('authenticate.dashboard');
    
                }else{
    
                    return back()->with([
    
                        'msg'   =>   'Not Authorized ',
            
                        'action'=>  'danger'
            
                    ]);  
    
                }
    
            } else {
    
                return back()->with([
    
                    'msg'       =>  'Invalid Username and Password',
        
                    'action'    =>  'warning'
        
                ]);
    
            }
        } else {
           
            
            return back()->with([
    
                'msg'       =>  'Invalid Username and Password',
    
                'action'    =>  'warning'
    
            ]);

        }
        

        

        

    }

    public function signOut(){

        if (Auth::guard('web')->check()) {

            Auth::guard('web')->logout();

            return redirect()->route('auth.login');

        }

    }

    public function getUserData($username,$password){

        return User::where('Username', $username)->where('Password', $password)->first();

    }
    

}
