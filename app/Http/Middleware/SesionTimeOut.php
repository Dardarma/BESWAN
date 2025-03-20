<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesionTimeOut
{
   public function handle(Request $request, Closure $next)
   {
        $timeout = config('session.lifetime') * 60;

        if(Auth::check()){

            $lastActivity = session('last_activity');

            if($lastActivity && (time() - $lastActivity > $timeout)){
                Auth::logout();
                session()->forget('last_activity');
                return redirect()->route('login')->with('error', 'Sesi anda telah berakhir, silahkan login kembali');
            }
            session(['last_activity' => time()]);
        }
        return $next($request);
    }

}

