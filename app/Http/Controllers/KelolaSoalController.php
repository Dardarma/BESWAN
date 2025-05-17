<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\soal_quiz;
use App\Models\type_soal;
use App\Models\Opsi_jawaban;
use Illuminate\Support\Facades\Validator;
use App\Helpers\quizHelper;

class KelolaSoalController extends Controller
{
    public function index(string $id)
    {
        // dd($id);
        try {
            $paginate = request()->input('paginate', 10);
            $search = request()->input('table_search');

            $type_soal = type_soal::select(
                'type_soal.id',
                'type_soal.tipe_soal',
                'type_soal.jumlah_soal',
                'type_soal.jumlah_soal_now',
                'quiz.judul as judul_quiz',
                'quiz.id as quiz_id',
            )
                ->join('quiz', 'type_soal.quiz_id', '=', 'quiz.id')
                ->where('type_soal.id', $id)
                ->firstOrFail();

            $soal_quiz = soal_quiz::select('soal_quiz.id', 'soal_quiz.media', 'soal_quiz.soal', 'soal_quiz.jawaban_benar')
                ->join('type_soal', 'soal_quiz.type_soal_id', '=', 'type_soal.id')
                ->where('soal_quiz.type_soal_id', $id)
                ->paginate($paginate);

            if ($type_soal->tipe_soal == 'pilihan_ganda') {
                $opsi = Opsi_jawaban::select('opsi_jawaban.id', 'opsi_jawaban.opsi', 'opsi_jawaban.soal_quiz_id', 'opsi_jawaban.is_true')
                    ->join('soal_quiz', 'opsi_jawaban.soal_quiz_id', '=', 'soal_quiz.id')
                    ->where('soal_quiz.type_soal_id', $id)
                    ->get()
                    ->groupBy('soal_quiz_id');
                dd($soal_quiz, $opsi);

                return view('admin_page.quiz.pilihan_ganda', compact('type_soal', 'soal_quiz', 'opsi'));
            } else if ($type_soal->tipe_soal == 'isian_singkat') {
                return view('admin_page.quiz.isian_singkat', compact('type_soal', 'soal_quiz'));
            } else if ($type_soal->tipe_soal == 'uraian') {
                return view('admin_page.quiz.esai', compact('type_soal', 'soal_quiz'));
            } else {
                return redirect()->back()->with('error', 'Tipe Soal Tidak Ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function createAndUpdatePilgan(Request $request)
    {
        // dd($request->all());
        try {

            $validator = Validator::make($request->all(), [
                'soal_quiz' => 'required|array',
                'soal_quiz.*.soal' => 'required|string',
                'soal_quiz.*.media' => 'nullable|file',
                'soal_quiz.*.jawaban_benar' => 'required|string',
                'soal_quiz.*.pilihan' => 'required|array',
                'soal_quiz.*.pilihan.*' => 'required|string',
                'quiz_id' => 'required|exists:quiz,id',
                'type_soal' => 'required|exists:type_soal,id',
            ], [
                'soal_quiz.*.soal.required' => 'Soal tidak boleh kosong.',
                'soal_quiz.*.media.file' => 'File media harus berupa file.',
                'soal_quiz.*.jawaban_benar.required' => 'Jawaban benar tidak boleh kosong.',
                'soal_quiz.*.pilihan.required' => 'Pilihan jawaban tidak boleh kosong.',
                'soal_quiz.*.pilihan.array' => 'Pilihan jawaban harus berupa array.',
                'soal_quiz.*.pilihan.*.required' => 'Setiap pilihan jawaban tidak boleh kosong.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            foreach ($request->soal_quiz as $key => $soalItem) {
                $soalId = is_numeric($key) ? $key : null;

                $mediaPath = null;
                if (isset($soalItem['media']) && $soalItem['media']) {
                    $mediaPath = $soalItem['media']->store('media_soal', 'public');
                }

                $soal_quiz = Soal_quiz::updateOrCreate(
                    [
                        'id' => $soalId,
                    ],
                    [
                        'soal' => $soalItem['soal'],
                        'media' => $mediaPath ?? null,
                        'jawaban_benar' => null,
                        'type_soal_id' => $data['type_soal'],
                        'quiz_id' => $data['quiz_id'],
                    ]
                );

                // Jika soal berupa pilihan ganda, simpan opsi
                if (!empty($soalItem['pilihan']) && is_array($soalItem['pilihan'])) {
                    // Hapus opsi lama jika update
                    Opsi_jawaban::where('soal_quiz_id', $soal_quiz->id)->delete();

                    foreach ($soalItem['pilihan'] as $index => $opsiText) {
                        $isTrue = ((string) $index === (string) $soalItem['jawaban_benar']);
                        Opsi_jawaban::create([
                            'soal_quiz_id' => $soal_quiz->id,
                            'opsi' => $opsiText,
                            'is_true' => $isTrue,
                        ]);
                    }
                }
            }

            $type_soal = type_soal::findOrFail($data['type_soal']);
            $type_soal->jumlah_soal_now = count($request->soal_quiz);
            $type_soal->save();

            // Update status aktif quiz jika semua tipe soal sudah terisi
            quizHelper::activeQuiz($request->quiz_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Soal berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function createAndUpdateSoal(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'soal_quiz' => 'required|array',
                'soal_quiz.*.soal' => 'required|string',
                'soal_quiz.*.media' => 'nullable|file',
                'soal_quiz.*.jawaban' => 'required if:tipe_soal,isian_singkat|string',
                'quiz_id' => 'required|exists:quiz,id',
                'tipe_soal' => 'required|exists:type_soal,id',
            ],);


            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }


            foreach ($request->soal_quiz as $key => $soalItem) {
                $soalId = is_numeric($key) ? $key : null;

                $mediaPath = null;
                if (isset($soalItem['media']) && $soalItem['media']) {
                    $mediaPath = $soalItem['media']->store('media_soal', 'public');
                }

                $soal_quiz = Soal_quiz::updateOrCreate(
                    [
                        'id' => $soalId,
                    ],
                    [
                        'soal' => $soalItem['soal'],
                        'media' => $mediaPath ?? null,
                        'jawaban_benar' => $soalItem['jawaban'] ?? null,
                        'type_soal_id' => $request->tipe_soal,
                        'quiz_id' => $request->quiz_id,
                    ]
                );
            }


            $type_soal = type_soal::findOrFail($request->tipe_soal);
            $type_soal->jumlah_soal_now = count($request->soal_quiz);
            $type_soal->save();
            quizHelper::activeQuiz($request->quiz_id);


            return response()->json([
                'status' => 'success',
                'message' => 'Soal berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function deleteOpsi(string $id)
    {
        try {
            $opsi = Opsi_jawaban::findOrFail($id);
            $opsi->delete();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function deleteSoal(string $id)
    {
        try {
            $soal = soal_quiz::findOrFail($id);

            if ($soal->media) {
                $path = public_path('storage/media_soal/' . $soal->media);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            if ($soal->tipe_soal == 'pilihan_ganda') {
                $opsi = Opsi_jawaban::where('soal_quiz_id', $id)->get();
                foreach ($opsi as $item) {
                    $item->delete();
                }
            }

            $type_soal = type_soal::findOrFail($soal->type_soal_id);
            $type_soal->jumlah_soal_now = $type_soal->jumlah_soal_now - 1;
            $type_soal->save();

            $soal->delete();

            quizHelper::activeQuiz($soal->quiz_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Soal berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
