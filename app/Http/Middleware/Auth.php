<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('userid')){
            // Check for remember me cookie
            if($request->hasCookie('userid')&&$request->hasCookie('username')){
                session([
                    'userid'=>$request->cookie('userid'),
                    'username'=>$request->cookie('username'),
                ]);
            }else{
            return redirect('/login');
            }
        }
        return $next($request);
    }
}
