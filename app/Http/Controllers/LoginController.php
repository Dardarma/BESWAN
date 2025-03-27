<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        
        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if($user->role == 'superadmin'){
                return redirect('/admin/master/user');
            }elseif($user->role == 'user'){
                return redirect('/admin/user/home');
            }else{
                return redirect('/admin/master/user');
            }
        } else {
            return redirect('/login')->with('error', 'Email atau Password Salah');

        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
