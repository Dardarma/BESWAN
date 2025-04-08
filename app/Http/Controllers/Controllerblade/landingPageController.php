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
        $level = level::select('id', 'urutan_level','nama_level','warna')
        ->orderBy('urutan_level', 'asc')
        ->get();

        // dd(auth()->user()->role);

        return view('user_page.Home.Home', compact('level'));
    }

    public function getProfile()
    {
        $userActiv = Auth::user();

        return view('user_page.profile.profile', ['userActiv' => $userActiv]);
    }

    public function materi(Request $request)
    {
        try{

            $role = Auth::user()->role;
            $paginate = $request->input('paginate', 10);
            $search = $request->input('search'); 

            if($role == 'superadmin || teacher'){
                $materi = Materi::select('materi.id', 'materi.judul_materi', 'materi.deskripsi_materi', 'materi.file_materi', 'materi.created_at', 'level.urutan_level')
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->when($search, function ($query, $search) {
                    $query->where('materi.judul_materi', 'like', '%' . $search . '%');
                })
                ->orderBy('level.urutan_level', 'desc')
                ->orderBy('materi.created_at', 'desc') 
                ->paginate($paginate);
            }else{
                $materi = Materi::select('materi.id', 'materi.judul_materi', 'materi.deskripsi_materi', 'materi.file_materi', 'materi.created_at', 'level.urutan_level')
                ->join('level', 'materi.id_level', '=', 'level.id')
                ->where('materi.id_level', auth()->user()->id_level)
                ->when($search, function ($query, $search) {
                    $query->where('materi.judul_materi', 'like', '%' . $search . '%');
                })
                ->orderBy('level.urutan_level', 'desc')
                ->orderBy('materi.created_at', 'desc') 
                ->paginate($paginate);
            }

            dd($materi);

            return view('user_page.materi.materi', compact('materi'), ['judul' => 'Data Materi']);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Gagal menampilkan data');
        }
        
        
    }
}
