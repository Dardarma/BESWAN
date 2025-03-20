<?php

namespace App\Http\Controllers\Controllerblade;;

use App\Http\Controllers\Controller;
use App\Models\quiz;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\level;
use App\Models\soal_quiz;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $quiz = quiz::select('quiz.id','quiz.jumlah_soal','quiz.judul','quiz.waktu_pengerjaan','quiz.type_soal','quiz.type_quiz','quiz.level_id','level.urutan_level')
        ->join('level','level.id','=','quiz.level_id')
        ->paginate(10);

        $level = level::select('id','urutan_level')->get();

        return view( 'admin_page.quiz.quiz_index',compact('quiz','level'));
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
        try{
            $request->validate(
                [
                    'judul' => 'required|string',
                    'jumlah_soal' => 'required|numeric',
                    'waktu_pengerjaan' => 'required|numeric',
                    'type_soal' => 'required|string',
                    'type_quiz' => 'required|string',
                    'level_id' => 'required|numeric'
                ]
            );
            

        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $quiz = Quiz::select(
                'quiz.id as quiz_id', 
                'quiz.jumlah_soal', 
                'quiz.judul', 
                'quiz.waktu_pengerjaan', 
                'quiz.type_soal', 
                'quiz.type_quiz', 
                'quiz.level_id', 
                'level.urutan_level', 
                'level.id as level_id'
            )
            ->join('level', 'level.id', '=', 'quiz.level_id')
            ->where('quiz.id', $id)
            ->firstOrFail();        

            $soalData = soal_quiz::select(
                'soal_quiz.id as soal_id',
                'soal_quiz.soal',
                'soal_quiz.type_soal',
                'soal_quiz.quiz_id',
                'opsi_jawaban.id as opsi_id',
                'opsi_jawaban.jawaban as opsi_jawaban',
                'opsi_jawaban.is_true'
            )
            ->leftJoin('opsi_jawaban', 'opsi_jawaban.soal_id', '=', 'soal_quiz.id')
            ->where('soal_quiz.quiz_id', $id)
            ->get()
            ->groupBy('soal_id') // Kelompokkan berdasarkan soal_id
            ->map(function ($items) {
                $soal = $items->first(); // Ambil data soal utama
                return [
                    'soal_id' => $soal->soal_id,
                    'pertanyaan' => $soal->soal,
                    'type_soal' => $soal->type_soal,
                    'opsi' => $items->map(function ($item) {
                        return [
                            'opsi_id' => $item->opsi_id,
                            'jawaban' => $item->opsi_jawaban,
                            'is_true' => $item->is_true,
                        ];
                    })->toArray(),
                ];
            })->values();
        
            $level = level::select('id','urutan_level')->get();

            return view('admin_page.quiz.quiz_soal',compact('quiz','level','soalData'));
            
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, quiz $quiz)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(quiz $quiz)
    {
        //
    }
}
