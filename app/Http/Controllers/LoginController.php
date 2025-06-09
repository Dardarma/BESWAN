<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        if (!$user) {
            return redirect('/login')->with('error', 'Email tidak terdaftar');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect('/login')->with('error', 'Password salah');
        }

        Auth::login($user);

        if ($user->role == 'superadmin') {
            return redirect('/admin/home');
        } elseif ($user->role == 'user') {
              if (!$user->levels || $user->levels()->count() === 0) {
                return redirect('/user/pretest');
            }
            return redirect('/user/home');
        } else {
            return redirect('/admin/home');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
