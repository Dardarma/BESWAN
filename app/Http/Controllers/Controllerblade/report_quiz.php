<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Models\opsi_jawaban;
use Illuminate\Http\Request;
use App\Models\quiz;
use App\Models\quiz_user;
use App\Models\soal_quiz;
use App\Models\SoalTerpilih;

class report_quiz extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);

            $quiz = Quiz::select('quiz.id as quiz_id', 'quiz.judul', 'level.nama_level', 'materi.judul as materi_judul', 'quiz.jumlah_soal')
                ->leftJoin('materi', 'materi.id', '=', 'quiz.materi_id')
                ->join('level', 'level.id', '=', 'quiz.level_id')
                ->when($search, function ($query, $search) {
                    $query->where('quiz.judul', 'like', '%' . $search . '%')
                        ->orWhere('level.nama_level', 'like', '%' . $search . '%')
                        ->orWhere('materi.judul', 'like', '%' . $search . '%');
                })
                ->paginate($paginate);

            // dd($quiz);

            return view('admin_page.report_quiz.quiz_list', compact('quiz'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function listUserQuiz(Request $request, string $id)
    {
        try {
            $search = $request->input('table_search');
            $paginate = $request->input('paginate', 10);


            $quiz_user = quiz_user::select('quiz_user.id as quiz_user_id', 'users.name', 'quiz_user.nilai_persen','quiz_user.status')
                ->join('users', 'users.id', '=', 'quiz_user.user_id')
                ->where('quiz_user.quiz_id', $id)
                ->when($search, function ($query, $search) {
                    $query->where('user.name', 'like', '%' . $search . '%');
                })
                ->paginate($paginate);

            $quiz = Quiz::findOrFail($id)
                ->join('materi', 'materi.id', '=', 'quiz.materi_id')
                ->join('level', 'level.id', '=', 'quiz.level_id')
                ->select('quiz.id as quiz_id', 'quiz.judul', 'level.nama_level', 'materi.judul as materi_judul', 'quiz.jumlah_soal', 'quiz.waktu_pengerjaan', 'quiz.total_skor')
                ->first();

            return view('admin_page.report_quiz.quiz_user_list', compact('quiz_user', 'quiz'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function preview_pilgan(string $id)
    {
        try {

            $id_quiz = quiz_user::select('quiz_id')
                ->where('id', $id)
                ->first();

            $soal = SoalTerpilih::select(
                'soal_terpilih.id as soal_terpilih_id',
                'soal_terpilih.id_opsi_jawaban',
                'soal_terpilih.nilai',
                'soal_terpilih.status_jawaban',
                'opsi_jawaban.opsi',
                'opsi_jawaban.is_true',
                'soal_quiz.soal',
                'soal_quiz.id as soal_id',
                'soal_terpilih.urutan_soal'
            )
                ->join('soal_quiz', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
                ->leftJoin('opsi_jawaban', 'opsi_jawaban.id', '=', 'soal_terpilih.id_opsi_jawaban') // ubah ini
                ->join('type_soal', 'type_soal.id', '=', 'soal_quiz.type_soal_id')
                ->where('soal_terpilih.quiz_user_id', $id)
                ->where('type_soal.tipe_soal', 'pilihan_ganda')
                ->orderBy('soal_terpilih.urutan_soal', 'asc')
                ->get();
                // dd($soal);


            foreach ($soal as  $item) {
                $opsi_jawaban = opsi_jawaban::select('id', 'opsi', 'is_true')
                    ->where('soal_quiz_id', $item->soal_id)->get();
                $item->opsi_jawaban_lengkap = $opsi_jawaban;
            }


            return view('admin_page.report_quiz.preview_pilgan', compact('soal', 'id', 'id_quiz'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function preview_isian_singkat(string $id)
    {
        try {
            $soal = SoalTerpilih::select(
                'soal_terpilih.id as soal_terpilih_id',
                'soal_terpilih.nilai',
                'soal_terpilih.status_jawaban',
                'soal_terpilih.jawaban',
                'soal_terpilih.urutan_soal',
                'soal_quiz.jawaban_benar',
                'soal_quiz.soal',
                'soal_quiz.id as soal_id',
            )
                ->join('soal_quiz', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
                ->join('type_soal', 'type_soal.id', '=', 'soal_quiz.type_soal_id')
                ->where('soal_terpilih.quiz_user_id', $id)
                ->where('type_soal.tipe_soal', 'isian_singkat')
                ->orderBy('soal_terpilih.urutan_soal', 'asc')
                ->get();

            $id_quiz = quiz_user::select('quiz_id')
                ->where('id', $id)
                ->first();

            return view('admin_page.report_quiz.preview_isian_singkat', compact('soal', 'id', 'id_quiz'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function preview_uraian(String $id)
    {
        try {
            $soal = SoalTerpilih::select(
                'soal_terpilih.id as soal_terpilih_id',
                'soal_terpilih.nilai',
                'soal_terpilih.status_jawaban',
                'soal_terpilih.jawaban',
                'soal_terpilih.nilai',
                'soal_terpilih.urutan_soal',
                'soal_quiz.soal',
                'type_soal.skor_per_soal',
            )
                ->join('soal_quiz', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
                ->join('type_soal', 'type_soal.id', '=', 'soal_quiz.type_soal_id')
                ->where('soal_terpilih.quiz_user_id', $id)
                ->where('type_soal.tipe_soal', 'uraian')
                ->orderBy('soal_terpilih.urutan_soal', 'asc')
                ->get();

            $id_quiz = quiz_user::select('quiz_id')
                ->where('id', $id)
                ->first();

            return view('admin_page.report_quiz.preview_uraian', compact('soal', 'id', 'id_quiz'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function NilaiUraian(Request $request)
    {
        try {
            $request->validate([
                'skor' => 'required|numeric',
                'soal_terpilih_id' => 'required|exists:soal_terpilih,id',
            ]);

            $soal_terpilih = SoalTerpilih::findOrFail($request->soal_terpilih_id);
            $soal_terpilih->update([
                'nilai' => $request->skor,
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Nilai berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
