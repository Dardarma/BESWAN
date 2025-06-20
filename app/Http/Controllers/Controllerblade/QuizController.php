<?php

namespace App\Http\Controllers\Controllerblade;;

use App\Http\Controllers\Controller;
use App\Models\quiz;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\level;
use App\Models\soal_quiz;
use App\Models\Materi;
use App\Models\type_soal;

use function PHPSTORM_META\type;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = request('table_search');
        $paginate = request('paginate') ?? 10;

        $quiz = Quiz::select('quiz.id as quiz_id', 'quiz.judul', 'level.nama_level', 'materi.judul as materi_judul','quiz.type')
            ->leftJoin('materi', 'materi.id', '=', 'quiz.materi_id')
            ->join('level', 'level.id', '=', 'quiz.level_id')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('quiz.judul', 'LIKE', "%{$search}%")
                      ->orWhere('level.nama_level', 'LIKE', "%{$search}%")
                      ->orWhere('materi.judul', 'LIKE', "%{$search}%");
                });
            })
            ->paginate($paginate)
            ->appends(request()->query());
        // dd($quiz);

        $level = level::select('id', 'nama_level', 'urutan_level')->get();

        return view('admin_page.quiz.quiz_index', compact('quiz', 'level'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'judul' => 'required',
                'level_id' => 'required',
                'waktu_pengerjaan' => 'required',
            ]);

            $validator->sometimes('materi_id', 'required', function ($input) {
                return $input->type === 'posttest';
            });

            $validator->validate();

            $quiz = Quiz::create([
                'judul' => $request->judul,
                'waktu_pengerjaan' => $request->waktu_pengerjaan,
                'type' => 'posttest',
                'materi_id' => $request->type === 'pretest' ? null : $request->materi_id,
                'level_id' => $request->level_id,
                'is_active' => 0,
            ]);

            $type_soalnya = ['pilihan_ganda', 'isian_singkat', 'uraian'];

            foreach ($type_soalnya as $type) {
                type_soal::create([
                    'tipe_soal' => $type,
                    'jumlah_soal' => 0,
                    'quiz_id' => $quiz->id,
                    'jumlah_soal' => 0,
                    'jumlah_soal_now' => 0,
                    'skor_per_soal' => 0,
                    'total_skor' => 0,
                ]);
            }

            $level = level::findOrFail($request->level_id);
            $level->jumlah_quiz_posttest += 1;
            $level->save();

            return redirect()->back()->with('success', 'Quiz created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $quiz = Quiz::select('quiz.id as quiz_id', 'quiz.level_id', 'quiz.materi_id', 'quiz.waktu_pengerjaan', 'quiz.judul', 'level.nama_level', 'quiz.type', 'materi.judul as materi_judul', 'quiz.is_active')
                ->leftJoin('materi', 'materi.id', '=', 'quiz.materi_id')
                ->join('level', 'level.id', '=', 'quiz.level_id')
                ->where('quiz.id', $id)
                ->firstOrFail();


            $type_soal = type_soal::select('id', 'tipe_soal', 'jumlah_soal', 'skor_per_soal', 'total_skor', 'jumlah_soal_now', 'quiz_id')
                ->where('quiz_id', $id)
                ->get();

                // dd($type_soal, $quiz);

            $level = level::select('id', 'nama_level', 'urutan_level')->get();

            $materi = Materi::select('id', 'judul')
                ->where('materi.id_level', $quiz->level_id)
                ->get();

            return view('admin_page.quiz.quiz_show', compact('quiz', 'level', 'materi', 'type_soal'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'judul' => 'required',
                'level_id' => 'required',
                'waktu_pengerjaan' => 'required',
            ]);

            $validator->sometimes('materi_id', 'required', function ($input) {
                return $input->type === 'posttest';
            });

            $validator->validate();

            $quiz = Quiz::findOrFail($id);

            $quiz->update([
                'judul' => $request->judul,
                'waktu_pengerjaan' => $request->waktu_pengerjaan,
                'type' => $request->type,
                'materi_id' => $request->type === 'pretest' ? null : $request->materi_id,
                'level_id' => $request->level_id,
            ]);
            return redirect()->back()->with('success', 'Quiz updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();

            return redirect()->back()->with('success', 'Quiz deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getMateri($level_id)
    {

        $materi = Materi::select('id', 'judul')
            ->where('id_level', $level_id)
            ->select('id', 'judul')
            ->get();

        return response()->json($materi);
    }

    public function updateType(Request $request)
    {
        try {

            $id = $request->id;

            $type_soal = type_soal::findOrFail($id);

            $jumlah_soal    = $request->jumlah_soal;
            $skor_per_soal  = $request->skor_per_soal;
            $total_skor     = $jumlah_soal * $skor_per_soal;

            $type_soal->update([
                'jumlah_soal'    => $jumlah_soal,
                'skor_per_soal'  => $skor_per_soal,
                'total_skor'     => $total_skor,
            ]);

            $quiz = quiz::findOrFail($type_soal->quiz_id);

            $total_skor = type_soal::where('quiz_id', $type_soal->quiz_id)
                ->sum('total_skor');
            $jumlah_soal = type_soal::where('quiz_id', $type_soal->quiz_id)
                ->sum('jumlah_soal');

            $quiz->update([
                'total_skor' => $total_skor,
                'jumlah_soal' => $jumlah_soal,
            ]);

            $type_soal = type_soal::select('id', 'tipe_soal', 'jumlah_soal', 'skor_per_soal', 'total_skor')
                ->where('id', $id)
                ->firstOrFail();



            return response()->json([
                'status' => 'success',
                'message' => 'Type updated successfully',
                'data' => $type_soal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

   
}
