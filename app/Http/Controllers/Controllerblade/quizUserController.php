<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Models\opsi_jawaban;
use Illuminate\Http\Request;
use App\Models\quiz;
use App\Models\type_soal;
use App\Models\quiz_user;
use App\Models\SoalTerpilih;
use App\Models\soal_quiz;
use App\Models\Level_Murid;
use Illuminate\Support\Facades\DB;
use App\Helpers\quizHelper;
use App\Service\Quiz_service;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;

class quizUserController extends Controller
{
    public function getQuizList(Request $request)
    {
        $paginate = $request->input('paginate', 10);
        $search = $request->input('table_search');
        $levelFilter = $request->input('level');

        $userLevelIds = auth()->user()->levels->pluck('id')->toArray();

        // Build the query
        $quizQuery = quiz::select('quiz.id', 'materi.judul as judul_materi', 'quiz.judul as judul_quiz', 'quiz.waktu_pengerjaan', 'level.urutan_level', 'level.warna', 'level.id as level_id', 'quiz.type')
            ->leftjoin('materi', 'quiz.materi_id', '=', 'materi.id')
            ->join('level', 'quiz.level_id', '=', 'level.id')
            ->where('quiz.is_active', 1)
            ->whereIn('level.id', $userLevelIds);

        // Apply level filter if selected
        if ($levelFilter) {
            $quizQuery->where('level.id', $levelFilter);
        }

        // Apply search filter if provided
        if ($search) {
            $quizQuery->where(function ($query) use ($search) {
                $query->where('quiz.judul', 'like', "%{$search}%")
                    ->orWhere('materi.judul', 'like', "%{$search}%");
            });
        }

        // Get the paginated results
        $quiz = $quizQuery->orderBy('level.urutan_level', 'desc')
            ->orderBy('quiz.created_at', 'desc')
            ->paginate($paginate)
            ->withQueryString(); // Preserve query parameters in pagination links

        // Add type_soal data to each quiz
        foreach ($quiz as $q) {
            $q->type_soal = type_soal::where('quiz_id', $q->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();
        }

        // Get levels for the filter dropdown
        if (Auth::user()->role == 'user') {
            $userLevels = Auth::user()->levels->pluck('id')->toArray();
            $levels = \App\Models\Level::select('id', 'nama_level')
                ->whereIn('id', $userLevels)
                ->orderBy('urutan_level')
                ->get();
        } else {
            // For admin/superadmin/teacher, show all levels
            $levels = \App\Models\Level::select('id', 'nama_level')
                ->orderBy('urutan_level')
                ->get();
        }

        // Get a single quiz for the table row display
        $q = count($quiz) > 0 ? $quiz[0] : null;

        return view('user_page.quiz_user.quiz_list', compact('quiz', 'q', 'levels'));
    }

    public function getQuizUser(string $id_quiz)
    {
        try {
            // dd($id_quiz);

            $user = auth()->user()->id;

            $quiz = quiz::select('quiz.id', 'materi.judul as judul_materi', 'quiz.judul as judul_quiz', 'quiz.waktu_pengerjaan', 'quiz.total_skor', 'quiz.jumlah_soal', 'quiz.type')
                ->leftjoin('materi', 'quiz.materi_id', '=', 'materi.id')
                ->where('quiz.id', $id_quiz)
                ->first();

            $type_soal = type_soal::where('quiz_id', $quiz->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();

            $quiz_user = quiz_user::select('nilai_total', 'nilai_persen', 'waktu_mulai', 'status', 'id')
                ->where('quiz_id', $id_quiz)
                ->where('user_id', $user)
                ->get();

            // dd($type_soal)

            return view('user_page.quiz_user.quiz_user', compact('quiz', 'quiz_user', 'type_soal'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ini erornya siapa ya' . $e->getMessage());
        }
    }

    public function start(string $Quizid)
    {
        try {
            $user = auth()->id();

            $quiz_user = DB::transaction(function () use ($Quizid, $user) {
                $quiz_user = quiz_user::create([
                    'quiz_id' => $Quizid,
                    'user_id' => $user,
                    'waktu_mulai' => now(),
                    'waktu_selesai' => now()->addMinutes(quiz::find($Quizid)->waktu_pengerjaan),
                    'status' => 'berlangsung',
                ]);

                $type_soal = type_soal::where('quiz_id', $Quizid)
                    ->select('id', 'tipe_soal', 'jumlah_soal')
                    ->get();

                foreach ($type_soal as $ts) {
                    $soal = DB::table('soal_quiz')
                        ->where('type_soal_id', $ts->id)
                        ->inRandomOrder()
                        ->limit($ts->jumlah_soal)
                        ->get();

                    foreach ($soal as $key => $s) {
                        DB::table('soal_terpilih')->insert([
                            'quiz_user_id' => $quiz_user->id,
                            'type_soal_id' => $ts->id,
                            'soal_id' => $s->id,
                            'urutan_soal' => $key + 1,
                            'jawaban' => null,
                            'id_opsi_jawaban' => null,
                            'status_jawaban' => 'kosong',
                            'nilai' => null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                return $quiz_user;
            });

            // Cari tipe soal yang tersedia untuk user ini
            $tipe_tersedia = type_soal::where('quiz_id', $Quizid)
                ->where('jumlah_soal', '>', 0)
                ->select('tipe_soal')
                ->pluck('tipe_soal')
                ->toArray();

            session(['tipe_tersedia' => $tipe_tersedia]);

            // dd($tipe_tersedia);

            if (in_array('pilihan_ganda', $tipe_tersedia)) {
                return redirect('user/quiz/kerjakan/pilihan_ganda/' . $quiz_user->id);
            } elseif (in_array('isian_singkat', $tipe_tersedia)) {
                return redirect('user/quiz/kerjakan/isian_singkat/' . $quiz_user->id);
            } elseif (in_array('uraian', $tipe_tersedia)) {
                return redirect('user/quiz/kerjakan/uraian/' . $quiz_user->id);
            } else {
                return redirect()->back()->with('error', 'Tidak ada tipe soal yang tersedia untuk quiz ini.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memulai quiz: ' . $e->getMessage());
        }
    }

    public function showPilihanGanda($id_quiz_user)
    {
        // dd($id_quiz_user);

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id', 'quiz.jumlah_soal')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $id_quiz_user)
            ->first();


        $jumlah_soal = type_soal::where('quiz_id', $quiz_user->quiz_id)
            ->where('tipe_soal', 'pilihan_ganda')
            ->select('jumlah_soal')
            ->first();

        $soal = soal_quiz::select(
            'soal_quiz.id',
            'soal_quiz.soal',
            'opsi_jawaban.id as opsi_id',
            'opsi_jawaban.opsi',
            'soal_terpilih.urutan_soal',
            'soal_terpilih.id as soal_terpilih_id',
            'soal_terpilih.id_opsi_jawaban',
            'media_soal.media',
            'media_soal.type_media',
            'media_soal.keterangan',
            'media_soal.id as media_soal_id',
        )
            ->join('soal_terpilih', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
            ->leftjoin('media_soal', 'soal_quiz.id', '=', 'media_soal.soal_id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->join('opsi_jawaban', 'soal_quiz.id', '=', 'opsi_jawaban.soal_quiz_id')
            ->where('soal_terpilih.quiz_user_id', $id_quiz_user)
            ->where('type_soal.tipe_soal', 'pilihan_ganda')
            ->orderBy('soal_terpilih.urutan_soal')
            ->orderBy('opsi_jawaban.id') // agar opsi tertata
            ->get();

        $tipe_tersedia = session('tipe_tersedia', []);

        $grouped = $soal->groupBy('id');

        return view('user_page.quiz_user.pilihan_ganda', compact('grouped', 'quiz_user', 'jumlah_soal', 'tipe_tersedia'));
    }

    public function showIsianSingkat($id_quiz_user)
    {
        // dd($id_quiz_user);

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id', 'quiz.jumlah_soal')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $id_quiz_user)
            ->first();

        $jumlah_soal = type_soal::where('quiz_id', $quiz_user->quiz_id)
            ->where('tipe_soal', 'isian_singkat')
            ->select('jumlah_soal')
            ->first();



        $soal = soal_quiz::select(
            'soal_quiz.id',
            'soal_quiz.soal',
            'soal_terpilih.urutan_soal',
            'soal_terpilih.id as soal_terpilih_id',
            'soal_terpilih.jawaban',
            'media_soal.media',
            'media_soal.type_media',
            'media_soal.keterangan',
            'media_soal.id as media_soal_id',
        )
            ->join('soal_terpilih', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->leftjoin('media_soal', 'soal_quiz.id', '=', 'media_soal.soal_id')
            ->where('soal_terpilih.quiz_user_id', $id_quiz_user)
            ->where('type_soal.tipe_soal', 'isian_singkat')
            ->orderBy('soal_terpilih.urutan_soal')
            ->get();

        $grouped = $soal->groupBy('id');

        $tipe_tersedia = session('tipe_tersedia', []);

        return view('user_page.quiz_user.isian_singkat', compact('quiz_user', 'jumlah_soal', 'grouped', 'tipe_tersedia'));
    }

    public function showUraian($id_quiz_user)
    {

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id', 'quiz.jumlah_soal')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $id_quiz_user)
            ->first();

        $jumlah_soal = type_soal::where('quiz_id', $quiz_user->quiz_id)
            ->where('tipe_soal', 'uraian')
            ->select('jumlah_soal')
            ->first();

        $soal = soal_quiz::select(
            'soal_quiz.id',
            'soal_quiz.soal',
            'soal_terpilih.urutan_soal',
            'soal_terpilih.id as soal_terpilih_id',
            'soal_terpilih.jawaban',
            'media_soal.media',
            'media_soal.type_media',
            'media_soal.keterangan',
            'media_soal.id as media_soal_id',
        )
            ->join('soal_terpilih', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->leftjoin('media_soal', 'soal_quiz.id', '=', 'media_soal.soal_id')
            ->where('soal_terpilih.quiz_user_id', $id_quiz_user)
            ->where('type_soal.tipe_soal', 'uraian')
            ->orderBy('soal_terpilih.urutan_soal')
            ->get();

        $grouped = $soal->groupBy('id');
        $tipe_tersedia = session('tipe_tersedia', []);
        // dd($soal,$quiz_user,$jumlah_soal);

        return view('user_page.quiz_user.uraian', compact('quiz_user', 'jumlah_soal', 'grouped', 'tipe_tersedia'));
    }

    public function simpanJawaban(Request $request)
    {
        try {
            $request->validate([
                'soal_terpilih_id' => 'required|exists:soal_terpilih,id',
                'jawaban' => 'required|string',
                'id_opsi_jawaban' => 'nullable|exists:opsi_jawaban,id',
            ]);
            $soal_terpilih = SoalTerpilih::findOrFail($request->soal_terpilih_id);
            $soal_terpilih->jawaban = $request->jawaban;
            $soal_terpilih->id_opsi_jawaban = $request->id_opsi_jawaban;
            $soal_terpilih->status_jawaban = 'terisi';
            $soal_terpilih->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Jawaban berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan jawaban: ' . $e->getMessage(),
            ]);
        }
    }

    public function kumpulkanJawaban(string $id_quiz_user)
    {

        try {
            $quizService = new Quiz_service();


            $quiz = quiz_user::select('quiz.type', 'quiz.id')
                ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
                ->where('quiz_user.id', $id_quiz_user)
                ->first();

            $quiz_type = $quiz->type;

            // dd($quiz);

            if ($quiz_type == 'posttest') {
                $response = $quizService->submitQuizAnswersPosttest($id_quiz_user);
                return redirect('user/quiz/' . $quiz->id)->with('success', $response['message']);
            } else if ($quiz_type == 'pretest') {
                $response = $quizService->submitQuizAnswersPretest($id_quiz_user);
                $nilai_persen = $response['nilai_persen'];
                $quiz_user = $response['quiz_user'];

                $level_user = Level_Murid::where('id_siswa', Auth::user()->id)->exists();

                $quiz = quiz::select('quiz.id', 'quiz.type', 'level.id as level_id', 'level.urutan_level')
                    ->join('level', 'quiz.level_id', '=', 'level.id')
                    ->where('quiz.id', $quiz_user->quiz_id)
                    ->first();

                // Level_Murid::firstOrCreate([
                //     'id_siswa' => Auth::user()->id,
                //     'id_level' => $quiz->level_id,
                // ]);

                if ($nilai_persen >= 60 && !$level_user) {
                    $level_terakhir = level::orderBy('urutan_level', 'desc')->first();


                    if ($quiz->urutan_level == $level_terakhir->urutan_level) {
                        $seluruh_level = level::select('id')->get();
                        foreach ($seluruh_level as $level) {
                            Level_Murid::firstOrCreate([
                                'id_siswa' => Auth::user()->id,
                                'id_level' => $level->id,
                            ]);
                        }
                        return redirect('user/hasil_pretest/' . $id_quiz_user)->with('success', 'Selamat, Anda telah lulus pretest. anda menyelesaikan pretest.');
                    } else {
                        \Log::info('Processing: looking for next pretest');

                        $quiz_id = DB::table('quiz')
                            ->join('level', 'quiz.level_id', '=', 'level.id')
                            ->where('quiz.type', 'pretest')
                            ->where('level.urutan_level', $quiz->urutan_level + 1)
                            ->select('quiz.id')
                            ->first();
                        return redirect('user/pretest/' . $quiz_id->id)->with('success', 'Selamat, Anda telah lulus pretest. Silakan lanjut ke pretest berikutnya.');
                    }

                    // dd($quiz_id, $quiz->urutan_level);

                } else if ($nilai_persen < 60 && !$level_user) {
                    \Log::info('Processing: nilai < 60 && !level_user');
                    if ($quiz->urutan_level == 1 || $quiz->urutan_level == 2) {
                        $level1 = level::where('urutan_level', 1)->first();
                        Level_Murid::firstOrCreate([
                            'id_siswa' => Auth::user()->id,
                            'id_level' => $level1->id,
                        ]);

                        return redirect('user/hasil_pretest/' . $id_quiz_user)->with('error', 'Maaf, Anda belum lulus pretest. Silakan coba lagi.');
                    } else {
                        $levels = level::where('urutan_level', '<', $quiz->urutan_level)->get();

                        foreach ($levels as $level) {
                            Level_Murid::firstOrCreate([
                                'id_siswa' => Auth::user()->id,
                                'id_level' => $level->id,
                            ]);
                        }
                        return redirect('user/hasil_pretest/' . $id_quiz_user)->with('error', 'Maaf, Anda belum lulus pretest. Silakan coba lagi.');
                    }
                } else if ($nilai_persen >= 60 && $level_user) {
                    \Log::info('Processing: nilai >= 60 && level_user');
                    Level_Murid::firstOrCreate([
                        'id_siswa' => Auth::user()->id,
                        'id_level' => $quiz->level_id,
                    ]);

                    return redirect('user/hasil_pretest/' . $id_quiz_user)->with('success', 'Selamat, Anda telah lulus pretest. Silakan lanjut ke pretest berikutnya.');
                } else if ($nilai_persen < 60 && $level_user) {
                    \Log::info('Processing: nilai < 60 && level_user');
                    return redirect('user/hasil_pretest/' . $id_quiz_user)->with('error', 'Maaf, Anda belum lulus pretest. Silakan coba lagi.');
                } else {
                    \Log::error('Unhandled condition', ['nilai_persen' => $nilai_persen, 'level_user' => $level_user]);
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat mengumpulkan jawaban.');
                }
            } else {
                return redirect()->back()->with('error', 'Tipe quiz tidak dikenali.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengumpulkan jawaban: ' . $e->getMessage());
        }
    }
}
