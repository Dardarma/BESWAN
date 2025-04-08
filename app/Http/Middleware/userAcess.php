<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class userAcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {   
        $rolesArray = explode('|', $roles);
        
        if(in_array(auth()->user()->role, $rolesArray)){
            return $next($request);
        }else{
            return redirect('/user/home')->with('error', 'You do not have access to this page.');
        }
    }
}
