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
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class quizUserController extends Controller
{
    public function getQuizList(Request $request)
    {

        $paginate = $request->input('paginate', 10);

        $level = auth()->user()->levels->pluck('id')->toArray();

        // dd($level);

        $quiz = quiz::select('quiz.id', 'materi.judul as judul_materi', 'quiz.judul as judul_quiz', 'quiz.waktu_pengerjaan')
            ->join('materi', 'quiz.materi_id', '=', 'materi.id')
            ->leftJoin('quiz_user', function ($join) {
                $join->on('quiz.id', '=', 'quiz_user.quiz_id')
                    ->where('quiz_user.user_id', auth()->user()->id)
                    ->where('quiz_user.updated_at', function ($query) {
                        $query->selectRaw('MAX(updated_at)')
                            ->from('quiz_user')
                            ->whereColumn('quiz_user.quiz_id', 'quiz.id')
                            ->where('quiz_user.user_id', auth()->user()->id);
                    });
            })
            ->where('quiz.is_active', 1)
            ->where('quiz.type', 'posttest')
            ->where('materi.id_level', $level)
            ->paginate($paginate);

        foreach ($quiz as $q) {
            $q->type_soal = type_soal::where('quiz_id', $q->id)->select('id', 'tipe_soal', 'jumlah_soal')->get();
        }

        // dd($quiz);

        return view('user_page.quiz_user.quiz_list', compact('quiz', 'q'));
    }

    public function getQuizUser(string $id_quiz)
    {
        try {

            $user = auth()->user()->id;

            $quiz = quiz::select('quiz.id', 'materi.judul as judul_materi', 'quiz.judul as judul_quiz', 'quiz.waktu_pengerjaan', 'quiz.total_skor', 'quiz.jumlah_soal')
                ->join('materi', 'quiz.materi_id', '=', 'materi.id')
                ->where('quiz.id', $id_quiz)
                ->first();

            $type_soal = type_soal::where('quiz_id', $quiz->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();


            $quiz_user = quiz_user::select('nilai_total', 'nilai_persen', 'waktu_mulai')
                ->where('quiz_id', $id_quiz)
                ->where('user_id', $user)
                ->get();

            return view('user_page.quiz_user.quiz_user', compact('quiz', 'quiz_user', 'type_soal'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mendapatkan data\n' . $e->getMessage());
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
            $tipe_tersedia = DB::table('soal_terpilih')
                ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
                ->where('soal_terpilih.quiz_user_id', $quiz_user->id)
                ->select('type_soal.tipe_soal')
                ->pluck('tipe_soal')
                ->toArray();

            if (in_array('pilihan_ganda', $tipe_tersedia)) {
                return redirect('user/quiz/kerjakan/pilihan_ganda/' . $quiz_user->id);
            } else {
                return back()->with('error', 'Tipe soal tidak tersedia');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memulai quiz: ' . $e->getMessage());
        }
    }

    public function showPilihanGanda($quiz_user_id)
    {

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id', 'quiz.jumlah_soal')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $quiz_user_id)
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
        )
            ->join('soal_terpilih', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->join('opsi_jawaban', 'soal_quiz.id', '=', 'opsi_jawaban.soal_quiz_id')
            ->where('soal_terpilih.quiz_user_id', $quiz_user_id)
            ->where('type_soal.tipe_soal', 'pilihan_ganda')
            ->orderBy('soal_terpilih.urutan_soal')
            ->orderBy('opsi_jawaban.id') // agar opsi tertata
            ->get();

        $grouped = $soal->groupBy('id');
        // dd($grouped);

        return view('user_page.quiz_user.pilihan_ganda', compact('grouped', 'quiz_user', 'jumlah_soal'));
    }

    public function showIsianSingkat($quiz_user_id)
    {

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id', 'quiz.jumlah_soal')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $quiz_user_id)
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
        )
            ->join('soal_terpilih', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->where('soal_terpilih.quiz_user_id', $quiz_user_id)
            ->where('type_soal.tipe_soal', 'isian_singkat')
            ->orderBy('soal_terpilih.urutan_soal')
            ->get();

        return view('user_page.quiz_user.isian_singkat', compact('quiz_user', 'jumlah_soal', 'soal'));
    }

    public function showUraian($quiz_user_id)
    {

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id', 'quiz.jumlah_soal')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $quiz_user_id)
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
        )
            ->join('soal_terpilih', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->where('soal_terpilih.quiz_user_id', $quiz_user_id)
            ->where('type_soal.tipe_soal', 'uraian')
            ->orderBy('soal_terpilih.urutan_soal')
            ->get();
        // dd($soal,$quiz_user,$jumlah_soal);

        return view('user_page.quiz_user.uraian', compact('quiz_user', 'jumlah_soal', 'soal'));
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

    public function kumpulkanJawaban(string $id_quiz_user, Request $request)
    {
        try {
            $quiz_user = quiz_user::findOrFail($id_quiz_user);
            $quiz_user->status = 'selesai';
            $waktu_now = now();

            if ($waktu_now < $quiz_user->waktu_selesai) {
                $quiz_user->waktu_selesai = $waktu_now;
                // dd('Waktu sudah habis');
            }

            $nilai_quiz = quiz::select('total_skor')->where('id', $quiz_user->quiz_id)->first();
            $nilai_quiz = $nilai_quiz->total_skor;
            // Reset nilai awal
            $quiz_user->nilai_total = 0;

            // Ambil semua soal yang dipilih user
            $soal_terpilih = SoalTerpilih::select('soal_terpilih.*', 'type_soal.tipe_soal as tipe_soal', 'type_soal.skor_per_soal')
                ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
                ->where('soal_terpilih.quiz_user_id', $id_quiz_user)
                ->get();

            // Periksa pilihan ganda
            $pilihan_ganda_user = SoalTerpilih::select(
                'soal_terpilih.*',
                'opsi_jawaban.is_true',
                'type_soal.skor_per_soal',
                'type_soal.tipe_soal',

            )
                ->leftJoin('opsi_jawaban', 'soal_terpilih.id_opsi_jawaban', '=', 'opsi_jawaban.id')
                ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
                ->where('soal_terpilih.quiz_user_id', $id_quiz_user)
                ->where('type_soal.tipe_soal', 'pilihan_ganda')
                ->get();

            foreach ($pilihan_ganda_user as $pg) {
                if (is_null($pg->id_opsi_jawaban)) {
                    $pg->status_jawaban_akhir = 'salah';
                    $pg->status_jawaban = 'dinilai';
                    $pg->nilai = 0;
                } elseif ($pg->is_true == 1) {
                    $pg->status_jawaban = 'dinilai';
                    $pg->status_jawaban_akhir = 'benar';
                    $pg->nilai = $pg->skor_per_soal;
                    $quiz_user->nilai_total += $pg->skor_per_soal;
                } else {
                    $pg->status_jawaban = 'salah';
                    $pg->status_jawaban_akhir = 'salah';
                    $pg->nilai = 0;
                }
                $pg->save();
            }


            // Periksa isian singkat
            $isian_singkat = $soal_terpilih->where('tipe_soal', 'isian_singkat');

            foreach ($isian_singkat as $is) {
                $soal = soal_quiz::find($is->soal_id);
                if (!$soal) {
                    continue;
                }

                if (trim(strtolower($is->jawaban)) === trim(strtolower($soal->jawaban_benar))) {
                    $is->status_jawaban = 'dinilai';
                    $is->status_jawaban_akhir = 'benar';
                    $is->nilai = $is->skor_per_soal;
                    $quiz_user->nilai_total += $is->skor_per_soal;
                } else {
                    $is->status_jawaban = 'dinilai';
                    $is->status_jawaban_akhir = 'salah';
                    $is->nilai = 0;
                }
                $is->save();
            }

            $quiz_user->nilai_persen = ($quiz_user->nilai_total / $nilai_quiz) * 100;

            if ($soal_terpilih->tipe_soal != 'uraian') {
                $quiz_user->status = 'dinilai';
            }

            $quiz_user->save();

            return redirect('/user/quiz/' . $quiz_user->quiz_id)->with('success', 'Jawaban berhasil dikumpulkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengumpulkan jawaban: ' . $e->getMessage());
        }
    }
}
