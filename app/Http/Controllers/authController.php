<?php

namespace App\Http\Controllers;
use App\Models\Cashier;
use Illuminate\Http\Request;

class authController extends Controller
{
    public function login(Request $rq){
        
        $email = $rq->email;
        $password = $rq->password;

        $user = Cashier::where('email',$email)->where('password',$password)->first();
        if($user){
            $username = $user->name;
            $userid = $user->id;
            $role = $user->role;
            session(['userid'=>$userid,'username'=>$username,'role'=>$role]);
            if($rq->has('remember_me')){
                cookie()->queue('userid',$userid,60*24*7);
                cookie()->queue('username',$username,60*24*7);
                cookie()->queue('role',$role,60*24*7);
            }
            return redirect('/');
        }else{
            $msg = session()->flash('status','Invalid Username or password');
            return redirect('/login');
        }

    }
    public function logout(Request $rq){
        $rq->session()->flush();
        cookie()->queue(cookie()->forget('userid'));
        cookie()->queue(cookie()->forget('username'));
        cookie()->queue(cookie()->forget('role'));
        return redirect('/login');

    }
}
