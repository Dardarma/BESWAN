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
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class landingPageController extends Controller
{
    public function getActivity()
    {
        $post = Activity_feed::all();
        return view('user_page.landing_page.landing_page', ['post' => $post]);
    }

    public function home()
    {
        try {
            $role = Auth::user()->role;
            if (in_array($role, ['superadmin', 'teacher'])) {
                $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level', 'warna')->get();
            } else {
                $level = Level::select('id', 'nama_level', 'deskripsi_level', 'urutan_level', 'warna')->where('id', auth()->user()->levels->pluck('id')->toArray())->get();
            }

            $level = DB::table('level')
                ->leftJoin('level_murid', function ($join) {
                    $join->on('level.id', '=', 'level_murid.id_level')
                        ->where('level_murid.id_siswa', '=', auth()->user()->id);
                })
                ->select(
                    'level.id as level_id',
                    'level.nama_level',
                    'level.deskripsi_level',
                    'level.urutan_level',
                    'level.warna',
                    'level.jumlah_quiz_posttest',
                    'level_murid.id as id_level_murid',
                    'level_murid.id_siswa',
                    'level_murid.exp'
                )
                ->orderBy('level.urutan_level')
                ->get();


            $level = $level->map(function ($item) {
                if ($item->exp !== null && $item->jumlah_quiz_posttest > 0) {
                    $item->exp_progress = round(($item->exp / $item->jumlah_quiz_posttest) * 100);
                } else {
                    $item->exp_progress = 0;
                }
                return $item;
            });

            return view('user_page.Home.Home', compact('level'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function chartDaily()
    {
        $total_activity = DB::table('daily_activity')->count();

        $data = DB::table('user_activity')
            ->selectRaw("DAYOFWEEK(tanggal_pengerjaan) as day_of_week, COUNT(*) as total")
            ->whereBetween('tanggal_pengerjaan', [
                now()->startOfWeek(), // Minggu
                now()->endOfWeek()    // Sabtu
            ])
            ->where('status', 1)
            ->groupByRaw('DAYOFWEEK(tanggal_pengerjaan)')
            ->pluck('total', 'day_of_week');

        $chart_data = [];
        for ($i = 1; $i <= 7; $i++) {
            $count = $data[$i] ?? 0;
            $percent = $total_activity > 0 ? round(($count / $total_activity) * 100, 2) : 0;
            $chart_data[] = $percent;
        }

        $labels = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        return view('user_page.home.chart', [
            'labels' => json_encode($labels),
            'values' => json_encode($chart_data)
        ]);
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

    public function editProfile(string $id_user, Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'no_hp' => 'nullable|string|max:15',
                'tanggal_lahir' => 'nullable|date',
                'alamat' => 'nullable|string|max:255',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'password' => 'nullable|string|min:8',
            ]);

            $user = User::findOrFail($id_user);

            $userData = [
                'name' => $request->name,
                'no_hp' => $request->no_hp,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
            ];

            // Only update password if it's not null
            if ($request->password) {
                $userData['password'] = bcrypt($request->password);
            }

            $user->update($userData);

            if ($request->hasFile('foto_profil')) {
                if ($user->foto_profil && Storage::exists($user->foto_profil)) {
                    Storage::delete($user->foto_profil);
                }

                $path_file = $request->file('foto_profil')->store('public/user');
                $user->update([
                    'foto_profil' => $path_file
                ]);
            }

            return redirect()->back()->with('success', 'Berhasil mengedit profil');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz_user.nilai_persen', 'quiz.id as quiz_id', 'quiz.waktu_pengerjaan')
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
