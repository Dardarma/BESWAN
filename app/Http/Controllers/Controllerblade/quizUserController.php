<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
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

        $quiz = quiz::select('quiz.id', 'materi.judul as judul_materi', 'quiz.judul as judul_quiz', 'quiz.waktu_pengerjaan', 'quiz_user.nilai')
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

            $quiz = quiz::select('quiz.id', 'materi.judul as judul_materi', 'quiz.judul as judul_quiz', 'quiz.waktu_pengerjaan')
                ->join('materi', 'quiz.materi_id', '=', 'materi.id')
                ->where('quiz.id', $id_quiz)
                ->first();

            $type_soal = type_soal::where('quiz_id', $quiz->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();


            $quiz_user = quiz_user::select('nilai', 'jawaban_benar', 'jawaban_salah', 'waktu_mulai')
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

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id')
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
            'soal_quiz.media',
            'opsi_jawaban.id as opsi_id',
            'opsi_jawaban.opsi',
            'soal_terpilih.urutan_soal',

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

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id')
            ->join('quiz', 'quiz_user.quiz_id', '=', 'quiz.id')
            ->where('quiz_user.id', $quiz_user_id)
            ->first();
        // dd($quiz_user);


        $jumlah_soal = type_soal::where('quiz_id', $quiz_user->quiz_id)
            ->where('tipe_soal', 'isian_singkat')
            ->select('jumlah_soal')
            ->first();



        $soal = soal_quiz::select(
            'soal_quiz.id',
            'soal_quiz.soal',
            'soal_quiz.media',
            'soal_terpilih.urutan_soal',
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

        $quiz_user = quiz_user::select('quiz_user.waktu_mulai', 'quiz_user.waktu_selesai', 'quiz.judul', 'quiz.id as quiz_id', 'quiz_user.id as quiz_user_id')
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
            'soal_quiz.media',
            'soal_terpilih.urutan_soal',
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
}
