<?php

namespace App\Http\Controllers\Controllerblade;

use App\Models\Activity_feed;
use App\Models\level;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class landingPageController extends Controller
{
    public function getActivity()
    {
        $post = Activity_feed::all();
        return view('user_page.landing_page.landing_page', ['post' => $post]);
    }

    public function home()
    {
        $role = Auth::user()->role;
        if(in_array($role, ['superadmin', 'teacher'])){
            $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level','warna')->get();
        }else{
            $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level','warna')->where('id', auth()->user()->levels->pluck('id')->toArray())->get();
        }

        return view('user_page.Home.Home', compact('level'));
    }

    public function getProfile()
    {
        $userActive = Auth::user();
        // dd($userActiv);

        return view('user_page.user_profile.user_profile', compact('userActive'));
    }


}
