<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Models\opsi_jawaban;
use App\Models\soal_quiz;
use Illuminate\Http\Request;

class SoalQuiz extends Controller
{
  
    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                'soal_quiz' => 'required|array',
                'soal_quiz.*.soal_id' => 'nullable|integer', 
                'soal_quiz.*.pertanyaan' => 'required|string',
                'soal_quiz.*.jawaban' => 'nullable|string',
                'type_soal' => 'required|string',
                'quiz_id' => 'required|integer',
                'soal_quiz.*.pilihan' => 'required_if:type_soal,pilihan_ganda|array|min:2',
            ], [
                'soal_quiz.*.jawaban.required_if' => 'Pilih salah satu jawaban untuk soal pilihan ganda.',
                'soal_quiz.*.pilihan.required_if' => 'Tambahkan minimal dua opsi untuk soal pilihan ganda.',
            ]);
        
            foreach ($data['soal_quiz'] as $soal) {
                $soalBaru = soal_quiz::updateOrCreate(
                    ['id' => $soal['soal_id'] ?? null],
                    [
                        'soal' => $soal['pertanyaan'],
                        'quiz_id' => $data['quiz_id'],
                        'type_soal' => $data['type_soal'],
                    ]
                );
        
                if ($data['type_soal'] == 'pilihan_ganda') {
                    opsi_jawaban::where('soal_id', $soalBaru->id)->delete();
        
                    foreach ($soal['pilihan'] as $key => $pilihan) {
                        opsi_jawaban::create([
                            'soal_id' => $soalBaru->id,
                            'jawaban' => $pilihan,
                            'is_true' => ($soal['jawaban'] === $pilihan) ? 1 : 0, 
                        ]);
                    }
                }
            }
        
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }        
  
    }
    

    public function destroySoal($id)
    {
        try {
            soal_quiz::destroy($id);
            return response()->json(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroyOpsi($id)
    {
        try {
            opsi_jawaban::destroy($id);
            return response()->json(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
