<?php

namespace App\Http\Controllers\Controllerblade;

use App\Helpers\quizHelper;
use App\Http\Controllers\Controller;
use App\Models\Media_soal;
use App\Models\opsi_jawaban;
use Illuminate\Http\Request;
use App\Models\quiz;
use App\Models\quiz_user;
use App\Models\soal_quiz;
use App\Models\SoalTerpilih;
use App\Models\type_soal;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

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


            $quiz_user = quiz_user::select('quiz_user.id as quiz_user_id', 'users.name', 'quiz_user.nilai_persen', 'quiz_user.status')
                ->join('users', 'users.id', '=', 'quiz_user.user_id')
                ->where('quiz_user.quiz_id', $id)
                ->when($search, function ($query, $search) {
                    $query->where('user.name', 'like', '%' . $search . '%');
                })
                ->paginate($paginate);

            $quiz = Quiz::findOrFail($id)
                ->leftjoin('materi', 'materi.id', '=', 'quiz.materi_id')
                ->join('level', 'level.id', '=', 'quiz.level_id')
                ->select('quiz.id as quiz_id', 'quiz.judul', 'level.nama_level', 'materi.judul as materi_judul', 'quiz.jumlah_soal', 'quiz.waktu_pengerjaan', 'quiz.total_skor')
                ->first();
            // dd($quiz);



            return view('admin_page.report_quiz.quiz_user_list', compact('quiz_user', 'quiz'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function preview_pilgan(Request $request, string $id)
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
                ->leftJoin('opsi_jawaban', 'opsi_jawaban.id', '=', 'soal_terpilih.id_opsi_jawaban')
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

                $media_soal = Media_soal::where('soal_id', $item->soal_id)->get();
                $item->media_soal = $media_soal;
            }

           $tipe_tersedia = type_soal::where('quiz_id', $id_quiz->quiz_id)
                ->where('jumlah_soal', '>', 0)
                ->select('tipe_soal')
                ->pluck('tipe_soal')
                ->toArray();

            if ($request->is('user/*')) {
                return view('user_page.report_quiz.preview_pilgan', compact('soal', 'id', 'id_quiz', 'tipe_tersedia'));
            } elseif ($request->is('admin/*')) {
                return view('admin_page.report_quiz.preview_pilgan', compact('soal', 'id', 'id_quiz', 'tipe_tersedia'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function preview_isian_singkat(Request $request, string $id)
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

            foreach ($soal as  $item) {
                $media_soal = Media_soal::where('soal_id', $item->soal_id)->get();
                $item->media_soal = $media_soal;
            }

            $tipe_tersedia = type_soal::where('quiz_id', $id_quiz->quiz_id)
                ->where('jumlah_soal', '>', 0)
                ->select('tipe_soal')
                ->pluck('tipe_soal')
                ->toArray();

            if ($request->is('user/*')) {
                return view('user_page.report_quiz.preview_isian_singkat', compact('soal', 'id', 'id_quiz', 'tipe_tersedia'));
            }
            if ($request->is('admin/*')) {
                return view('admin_page.report_quiz.preview_isian_singkat', compact('soal', 'id', 'id_quiz', 'tipe_tersedia'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function preview_uraian(Request $request, String $id)
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
                'soal_quiz.id as soal_id'
            )
                ->join('soal_quiz', 'soal_quiz.id', '=', 'soal_terpilih.soal_id')
                ->join('type_soal', 'type_soal.id', '=', 'soal_quiz.type_soal_id')
                ->leftJoin('media_soal', 'media_soal.soal_id', '=', 'soal_quiz.id')
                ->where('soal_terpilih.quiz_user_id', $id)
                ->where('type_soal.tipe_soal', 'uraian')
                ->orderBy('soal_terpilih.urutan_soal', 'asc')
                ->get();

            $id_quiz = quiz_user::select('quiz_id')
                ->where('id', $id)
                ->first();

            foreach ($soal as  $item) {
                $media_soal = Media_soal::where('soal_id', $item->soal_id)->get();
                $item->media_soal = $media_soal;
            }

            $tipe_tersedia = type_soal::where('quiz_id', $id_quiz->quiz_id)
                ->where('jumlah_soal', '>', 0)
                ->select('tipe_soal')
                ->pluck('tipe_soal')
                ->toArray();


            if ($request->is('user/*')) {
                return view('user_page.report_quiz.preview_uraian', compact('soal', 'id', 'id_quiz', 'tipe_tersedia'));
            } else if ($request->is('admin/*')) {
                return view('admin_page.report_quiz.preview_uraian', compact('soal', 'id', 'id_quiz', 'tipe_tersedia'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function NilaiUraian(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.skor' => 'required|numeric',
                'items.*.soal_terpilih_id' => 'required|exists:soal_terpilih,id',
            ]);

            $quiz_user_id = null;

            foreach ($request->items as $item) {
                $soal_terpilih = SoalTerpilih::findOrFail($item['soal_terpilih_id']);
                $soal_terpilih->update([
                    'nilai' => $item['skor'],
                    'status_jawaban' => 'dinilai',
                ]);

                // Simpan satu kali quiz_user_id dari salah satu soal
                $quiz_user_id = $soal_terpilih->quiz_user_id;
            }

            if ($quiz_user_id) {
                $quiz_user_obj = quiz_user::findOrFail($quiz_user_id);

                // Recalculate total score
                $total_nilai = SoalTerpilih::where('quiz_user_id', $quiz_user_id)
                    ->where('status_jawaban', 'dinilai')
                    ->sum('nilai');
                // dd($total_nilai->toArray());

                $quiz = quiz::findOrFail($quiz_user_obj->quiz_id);
                $total_skor = $quiz->total_skor;

                $quiz_user_obj->nilai_total = $total_nilai;
                $quiz_user_obj->nilai_persen = ($total_skor > 0) ? ($total_nilai / $total_skor) * 100 : 0;

                // Update status dan exp
                quizHelper::changeStatusQuiz($quiz_user_id);
                quizHelper::addExp($quiz_user_id, $quiz_user_obj->nilai_persen, $quiz_user_obj->user_id);
                $quiz_user_obj->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Nilai berhasil diperbarui secara kolektif',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function redirectReportQuiz(String $id)
    {
        try{
            $quiz_user = quiz_user::findOrFail($id);

            $tipe_tersedia = type_soal::where('quiz_id',$quiz_user->quiz_id) 
                ->where('jumlah_soal', '>', 0)
                ->select('tipe_soal')
                ->pluck('tipe_soal')
                ->toArray();

            $role = Auth::user()->role;

            if($role == 'user'){
                if (in_array('pilihan_ganda', $tipe_tersedia)) {
                    return redirect("/user/quiz_report/pilihan_ganda/{$id}");
                } elseif (in_array('isian_singkat', $tipe_tersedia)) {
                    return redirect("/user/quiz_report/isian_singkat/{$id}");
                } elseif (in_array('uraian', $tipe_tersedia)) {
                    return redirect("/user/quiz_report/uraian/{$id}");
                }
                return redirect()->back()->with('error', 'tipe soal tidak ditemukan, role user');
            }else if($role == 'superadmin' || $role == 'teacher'){
                if (in_array('pilihan_ganda', $tipe_tersedia)) {
                    return redirect("/admin/quiz_report/pilihan_ganda/{$id}");
                } elseif (in_array('isian_singkat', $tipe_tersedia)) {
                    return redirect("/admin/quiz_report/isian_singkat/{$id}");
                } elseif (in_array('uraian', $tipe_tersedia)) {
                    return redirect("/admin/quiz_report/uraian/{$id}");
                }
                return redirect()->back()->with('error', 'tipe soal tidak ditemukan, role superadmin/teacher');
            }
            return redirect()->back()->with('error', 'role tidak ditemukan ');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
