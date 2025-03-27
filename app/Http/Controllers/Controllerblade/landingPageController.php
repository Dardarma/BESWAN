<?php

namespace App\Http\Controllers\Controllerblade;

use App\Models\Activity_feed;
use App\Models\level;
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
        $level = level::select('id', 'urutan_level','nama_level','warna')
        ->orderBy('urutan_level', 'asc')
        ->get();

        return view('user_page.Home.Home', compact('level'));
    }

    public function getProfile()
    {
        $userActiv = Auth::user();

        return view('user_page.profile.profile', ['userActiv' => $userActiv]);
    }

    public function materi()
    {

    }
}
