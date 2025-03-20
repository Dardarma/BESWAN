<?php

namespace App\Http\Controllers\Controllerblade;

use App\Models\Activity_feed;
use App\Models\level;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class landingPageController extends Controller
{
    public function getActivity()
    {
        $post = Activity_feed::all();
        return view('user_page.landing_page.landing_page', ['post' => $post]);
    }

    public function levelchose()
    {
        $level = level::select('id', 'urutan_level','nama_level')->get();

        return view('user_page.Level_chose.levelChose', compact('level'));
    }
}
