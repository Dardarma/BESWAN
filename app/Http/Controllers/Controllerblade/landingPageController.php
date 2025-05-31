<?php

namespace App\Http\Controllers\Controllerblade;

use App\Models\Activity_feed;
use App\Models\level;
use App\Models\quiz;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\type_soal;
use App\Models\quiz_user;

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
        if (in_array($role, ['superadmin', 'teacher'])) {
            $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level', 'warna')->get();
        } else {
            $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level', 'warna')->where('id', auth()->user()->levels->pluck('id')->toArray())->get();
        }

        return view('user_page.Home.Home', compact('level'));
    }

    public function getProfile()
    {
        $userActive = Auth::user();
        $role = $userActive->role;

        if ($role == 'user') {
            return view('user_page.user_profile.user_profile', compact('userActive'));
        } else {
            return view('admin_page.user_profile', compact('userActive'));
        }
    }

    public function Pretest(Request $request)
    {
        try {

            $level = level::select('id')
                ->where('urutan_level', 1)
                ->first();

            $quiz = quiz::select('id', 'judul', 'jumlah_soal', 'waktu_pengerjaan')
                ->where('level_id', $level->id)
                ->where('type', 'pretest')
                ->first();

            $type_soal = type_soal::where('quiz_id', $quiz->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();


            return view('user_page.landing_page.pretest_landing_page', compact('quiz', 'type_soal'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function PretestNext(String $quiz_id)
    {
        try {

            $quiz = quiz::select('id', 'judul', 'jumlah_soal', 'waktu_pengerjaan')
                ->where('id', $quiz_id)
                ->first();

            $type_soal = type_soal::where('quiz_id', $quiz->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();

            return view('user_page.landing_page.pretest_landing_page', compact('quiz', 'type_soal'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pretestHasil(string $quiz_user_id)
    {
        try {
            $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz_user.nilai_persen', 'quiz.id as quiz_id','quiz.waktu_pengerjaan')
                ->join('quiz', 'quiz.id', '=', 'quiz_user.quiz_id')
                ->where('quiz_user.id', $quiz_user_id)
                ->first();

            $type_soal = type_soal::where('quiz_id', $quiz_user->quiz_id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();

            if ($quiz_user->nilai_persen >= 70) {
                $status = 'lulus';
            } else {
                $status = 'tidak_lulus';
            }
            return view('user_page.landing_page.hasil_pretest', compact('quiz_user', 'type_soal', 'status'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
