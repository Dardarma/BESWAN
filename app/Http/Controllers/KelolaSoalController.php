<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\soal_quiz;
use App\Models\type_soal;
use App\Models\Opsi_jawaban;
use Illuminate\Support\Facades\Validator;
use App\Helpers\quizHelper;
use App\Models\Media_soal;
use App\Helpers\MediaHelper;

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

            $soal_quiz = soal_quiz::select('soal_quiz.id', 'soal_quiz.soal', 'soal_quiz.jawaban_benar')
                ->join('type_soal', 'soal_quiz.type_soal_id', '=', 'type_soal.id')
                ->where('soal_quiz.type_soal_id', $id)
                ->paginate($paginate);

            $media_soal = Media_soal::select('media_soal.id', 'media_soal.media', 'media_soal.soal_id', 'media_soal.keterangan')
                ->join('soal_quiz', 'media_soal.soal_id', '=', 'soal_quiz.id')
                ->where('soal_quiz.type_soal_id', $id)
                ->get()
                ->groupBy('soal_id');

            // dd($media_soal);

            if ($type_soal->tipe_soal == 'pilihan_ganda') {
                $opsi = Opsi_jawaban::select('opsi_jawaban.id', 'opsi_jawaban.opsi', 'opsi_jawaban.soal_quiz_id', 'opsi_jawaban.is_true')
                    ->join('soal_quiz', 'opsi_jawaban.soal_quiz_id', '=', 'soal_quiz.id')
                    ->where('soal_quiz.type_soal_id', $id)
                    ->get()
                    ->groupBy('soal_quiz_id');

                return view('admin_page.quiz.pilihan_ganda', compact('type_soal', 'soal_quiz', 'opsi', 'media_soal'));
            } else if ($type_soal->tipe_soal == 'isian_singkat') {
                return view('admin_page.quiz.isian_singkat', compact('type_soal', 'soal_quiz', 'media_soal'));
            } else if ($type_soal->tipe_soal == 'uraian') {
                return view('admin_page.quiz.esai', compact('type_soal', 'soal_quiz', 'media_soal'));
            } else {
                return redirect()->back()->with('error', 'Tipe Soal Tidak Ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function createAndUpdatePilgan(Request $request)
    {
        // dd($request->media_files);
        try {
            $validator = Validator::make($request->all(), [
                'soal_quiz' => 'required|array',
                'soal_quiz.*.soal' => 'required|string',
                'soal_quiz.*.jawaban_benar' => 'required|string',
                'soal_quiz.*.pilihan' => 'required|array',
                'soal_quiz.*.pilihan.*' => 'required|string',
                'quiz_id' => 'required|exists:quiz,id',
                'type_soal' => 'required|exists:type_soal,id',
                'media_files' => 'nullable|array',
                'media_files.*' => 'nullable|array',
                'media_files.*.*.file' => 'nullable|file|max:102040|mimes:jpeg,jpg,png,mp3,wav',
                'media_files.*.*.id' => 'nullable|exists:media_soal,id',
                'media_files.*.*.keterangan' => 'nullable|string',
            ], [
                'soal_quiz.*.soal.required' => 'Soal tidak boleh kosong.',
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

                $soal_quiz = Soal_quiz::updateOrCreate(
                    [
                        'id' => $soalId,
                    ],
                    [
                        'soal' => $soalItem['soal'],
                        'jawaban_benar' => null, // We'll store actual answer in options
                        'type_soal_id' => $data['type_soal'],
                        'quiz_id' => $data['quiz_id'],
                    ]
                );

                // Process options for multiple choice questions
                if (!empty($soalItem['pilihan']) && is_array($soalItem['pilihan'])) {
                    // Delete old options if updating
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

                // Handle media files
                $actualSoalId = $soal_quiz->id;

                // Process media files if they exist for this question
                if (isset($request->media_files) && isset($request->media_files[$key])) {
                    $mediaItems = $request->media_files[$key];

                    foreach ($mediaItems as $mediaIndex => $mediaItem) {
                        $mediaId = $mediaItem['id'] ?? null;
                        $hasNewFile = isset($mediaItem['file']) && $mediaItem['file'] instanceof \Illuminate\Http\UploadedFile;

                        // Siapkan data dasar
                        $mediaData = [
                            'soal_id' => $actualSoalId,
                            'keterangan' => $mediaItem['keterangan'] ?? null,
                        ];

                        // Jika ada file baru
                        if ($hasNewFile) {
                            $mediaData['media'] = $mediaItem['file']->store('media_soal', 'public');
                            $mediaData['tipe'] = MediaHelper::detectMediaType($mediaItem['file']);
                        }

                        // Jika media ID ada (update)
                        if ($mediaId) {
                            // Update keterangan saja jika tidak ada file baru
                            Media_soal::where('id', $mediaId)->update($mediaData);
                        } elseif ($hasNewFile) {
                            // Jika tidak ada ID dan file baru ada, buat entri baru
                            Media_soal::create($mediaData);
                        }
                    }
                }
            }

            // Update the count of questions
            $type_soal = type_soal::findOrFail($data['type_soal']);
            $type_soal->jumlah_soal_now = count($request->soal_quiz);
            $type_soal->save();

            // Update quiz active status if all question types are filled
            quizHelper::activeQuiz($request->quiz_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Soal berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'error_detail' => $e->getTraceAsString()
            ]);
        }
    }

    public function createAndUpdateSoal(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'soal_quiz' => 'required|array',
                'soal_quiz.*.soal' => 'required|string',
                'soal_quiz.*.jawaban' => 'required_if:tipe_soal,isian_singkat|string',
                'quiz_id' => 'required|exists:quiz,id',
                'tipe_soal' => 'required|exists:type_soal,id',
                'media_files.*.*.file' => 'nullable|file|max:102040|mimes:jpeg,jpg,png,mp3,wav',
                'media_files.*.*.keterangan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Process soal quiz data
            foreach ($request->soal_quiz as $key => $soalItem) {
                $soalId = is_numeric($key) ? $key : null;

                // Create/update the soal_quiz entry
                $soalQuiz = Soal_quiz::updateOrCreate(
                    ['id' => $soalId],
                    [
                        'soal' => $soalItem['soal'],
                        'jawaban_benar' => $soalItem['jawaban'] ?? null,
                        'type_soal_id' => $request->tipe_soal,
                        'quiz_id' => $request->quiz_id,
                    ]
                );

                // Get the actual soal ID (might be new)
                $actualSoalId = $soalQuiz->id;

                // Process media files
                if (isset($request->media_files[$key])) {
                    foreach ($request->media_files[$key] as $mediaItem) {
                        $data = [
                            'soal_id' => $actualSoalId,
                            'keterangan' => $mediaItem['keterangan'] ?? null,
                        ];

                        // Cek apakah 'file' ada sebelum digunakan
                        if (isset($mediaItem['file']) && $mediaItem['file'] instanceof \Illuminate\Http\UploadedFile) {
                            $data['media'] = $mediaItem['file']->store('media_soal', 'public');
                            $data['tipe'] = MediaHelper::detectMediaType($mediaItem['file']);
                            // dd($data);
                        }

                        // Kalau tidak ada file baru, tetap update keterangan saja
                        if (isset($mediaItem['media_id'])) {
                            Media_soal::updateOrCreate(
                                ['id' => $mediaItem['media_id']],
                                $data
                            );
                        } elseif (isset($data['media'])) {
                            Media_soal::create([
                                'soal_id' => $actualSoalId,
                                'media' => $data['media'],
                                'type_media' => $data['tipe'],
                                'keterangan' => $data['keterangan'],
                            ]);
                        }
                    }
                }
            }

            // Update soal count
            $type_soal = type_soal::findOrFail($request->tipe_soal);
            $type_soal->jumlah_soal_now = count($request->soal_quiz);
            $type_soal->save();

            // Update quiz status
            quizHelper::activeQuiz($request->quiz_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Soal berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
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

    public function deleteMedia(string $id)
    {
        try {
            $media = Media_soal::findOrFail($id);
            $media->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Media berhasil dihapus.',
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
