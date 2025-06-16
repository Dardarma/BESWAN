<?php

namespace App\Service;

use App\Models\quiz;
use App\Models\quiz_user;
use App\Models\SoalTerpilih;
use App\Models\soal_quiz;
use App\Models\type_soal;
use App\Helpers\quizHelper;
use App\Models\Level_Murid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Quiz_service
{
    /**
     * Check database connection before starting transaction
     *
     * @return bool
     */
    private function checkDatabaseConnection()
    {        try {
            Log::info('Checking database connection...');
            DB::connection()->getPdo();
            Log::info('Database connection successful');
            return true;
        } catch (\Exception $e) {
            Log::error('Database connection failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Submit all answers for a quiz and calculate the score
     *
     * @param string $quiz_user_id
     * @return array
     */    public function submitQuizAnswersPosttest(string $quiz_user_id)
    {
        try {
            Log::info('Starting quiz submission for user: ' . $quiz_user_id);
            
            // Check database connection first
            if (!$this->checkDatabaseConnection()) {
                throw new \Exception('Database connection failed');
            }
            
            DB::beginTransaction();
            Log::info('Transaction started successfully');

            // Update quiz status and timing
            $quiz_user = $this->updateQuizStatus($quiz_user_id);
            \Log::info('Quiz status updated');

            // Get all selected questions
            $soal_terpilih = $this->getAllSelectedQuestions($quiz_user_id);
            \Log::info('Retrieved selected questions: ' . $soal_terpilih->count());

            // Score multiple choice questions
            $this->scorePilihanGanda($quiz_user_id, $quiz_user);
            \Log::info('Multiple choice questions scored');

            // Score short answer questions
            $this->scoreIsianSingkat($soal_terpilih, $quiz_user);
            \Log::info('Short answer questions scored');

            // Mark essay questions as filled
            $this->markUraianQuestions($soal_terpilih);
            \Log::info('Essay questions marked');

            // Calculate percentage score
            $nilai_persen = $this->calculatePercentageScore($quiz_user);
            \Log::info('Percentage score calculated: ' . $nilai_persen);

            // Process quiz level and status
            $this->processQuizLevel($quiz_user);
            \Log::info('Quiz level processed');

            // Update quiz status using helper
            quizHelper::changeStatusQuiz($quiz_user->id);
            \Log::info('Quiz status updated via helper');

            $user_id = Auth::user()->id;
            // Add experience points if applicable
            quizHelper::addExp($quiz_user_id, $nilai_persen, $user_id);
            \Log::info('Experience points added');

            // Save and commit
            $quiz_user->save();
            \Log::info('Quiz user saved');

            DB::commit();
            \Log::info('Transaction committed successfully');

            return [
                'status' => 'success',
                'message' => 'Jawaban berhasil dikumpulkan',
                'quiz_user' => $quiz_user
            ];
            
        } catch (\Exception $e) {
            \Log::error('Quiz submission failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Gagal mengumpulkan jawaban: ' . $e->getMessage()
            ];
        }
    }



    /**
     * Submit all answers for a quiz and calculate the score
     *
     * @param string $quiz_user_id
     * @return array
     */    public function submitQuizAnswersPretest(string $quiz_user_id) 
    {
        try {
            \Log::info('Starting pretest submission for user: ' . $quiz_user_id);
            
            DB::beginTransaction();
            \Log::info('Pretest transaction started successfully');

            // Update quiz status and timing
            $quiz_user = $this->updateQuizStatus($quiz_user_id);
            \Log::info('Pretest quiz status updated');

            // Get all selected questions
            $soal_terpilih = $this->getAllSelectedQuestions($quiz_user_id);
            \Log::info('Pretest retrieved selected questions: ' . $soal_terpilih->count());

            // Score multiple choice questions
            $this->scorePilihanGanda($quiz_user_id, $quiz_user);
            \Log::info('Pretest multiple choice questions scored');

            // Score short answer questions
            $this->scoreIsianSingkat($soal_terpilih, $quiz_user);
            \Log::info('Pretest short answer questions scored');

            // Calculate percentage score
            $nilai_persen = $this->calculatePercentageScore($quiz_user);
            \Log::info('Pretest percentage score calculated: ' . $nilai_persen);

            // Process quiz level and status    
            $this->processQuizLevel($quiz_user);
            \Log::info('Pretest quiz level processed');

            // Update quiz status using helper
            quizHelper::changeStatusQuiz($quiz_user->id);
            \Log::info('Pretest quiz status updated via helper');

            $quiz_user->save();
            \Log::info('Pretest quiz user saved');
            
            DB::commit();
            \Log::info('Pretest transaction committed successfully');

            return [
                'status' => 'success',
                'message' => 'Jawaban berhasil dikumpulkan',
                'quiz_user' => $quiz_user,
                'nilai_persen' => $nilai_persen
            ];

        } catch (\Exception $e) {
            \Log::error('Pretest submission failed: ' . $e->getMessage());
            \Log::error('Pretest stack trace: ' . $e->getTraceAsString());
            
            DB::rollBack();
            return [
                'status' => 'error',
                'message' => 'Gagal mengumpulkan jawaban: ' . $e->getMessage()
            ];
        }
    }    /**
     * Update quiz status and timing
     *
     * @param string $quiz_user_id
     * @return quiz_user
     */
    private function updateQuizStatus(string $quiz_user_id)
    {
        try {
            \Log::info('Attempting to find quiz_user with ID: ' . $quiz_user_id);
            
            $quiz_user = quiz_user::findOrFail($quiz_user_id);
            \Log::info('Quiz_user found successfully');
            
            $quiz_user->status = 'selesai';
            $waktu_now = now();
            \Log::info('Setting status to selesai, current time: ' . $waktu_now);

            if ($waktu_now < $quiz_user->waktu_selesai) {
                $quiz_user->waktu_selesai = $waktu_now;
                \Log::info('Updated waktu_selesai to current time');
            }

            $quiz_user->nilai_total = 0; // Reset initial score
            \Log::info('Reset nilai_total to 0');

            return $quiz_user;
            
        } catch (\Exception $e) {
            \Log::error('Error in updateQuizStatus: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Get all selected questions for a quiz
     *
     * @param string $quiz_user_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getAllSelectedQuestions(string $quiz_user_id)
    {
        return SoalTerpilih::select('soal_terpilih.*', 'type_soal.tipe_soal as tipe_soal', 'type_soal.skor_per_soal')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->where('soal_terpilih.quiz_user_id', $quiz_user_id)
            ->get();
    }

    /**
     * Score multiple choice questions
     *
     * @param string $quiz_user_id
     * @param quiz_user $quiz_user
     * @return void
     */
    private function scorePilihanGanda(string $quiz_user_id, quiz_user $quiz_user)
    {
        $pilihan_ganda_user = SoalTerpilih::select(
            'soal_terpilih.*',
            'opsi_jawaban.is_true',
            'type_soal.skor_per_soal',
            'type_soal.tipe_soal'
        )
            ->leftJoin('opsi_jawaban', 'soal_terpilih.id_opsi_jawaban', '=', 'opsi_jawaban.id')
            ->join('type_soal', 'soal_terpilih.type_soal_id', '=', 'type_soal.id')
            ->where('soal_terpilih.quiz_user_id', $quiz_user_id)
            ->where('type_soal.tipe_soal', 'pilihan_ganda')
            ->get();

        foreach ($pilihan_ganda_user as $pg) {
            if (is_null($pg->id_opsi_jawaban)) {
                $this->markAsWrong($pg);
            } elseif ($pg->is_true == 1) {
                $this->markAsCorrect($pg);
                $quiz_user->nilai_total += $pg->skor_per_soal;
            } else {
                $this->markAsWrong($pg);
            }
        }
    }

    /**
     * Score short answer questions
     *
     * @param \Illuminate\Database\Eloquent\Collection $soal_terpilih
     * @param quiz_user $quiz_user
     * @return void
     */
    private function scoreIsianSingkat($soal_terpilih, quiz_user $quiz_user)
    {
        $isian_singkat = $soal_terpilih->where('tipe_soal', 'isian_singkat');

        foreach ($isian_singkat as $is) {
            $soal = soal_quiz::find($is->soal_id);
            if (!$soal) {
                continue;
            }

            if (trim(strtolower($is->jawaban)) === trim(strtolower($soal->jawaban_benar))) {
                $this->markAsCorrect($is);
                $quiz_user->nilai_total += $is->skor_per_soal;
            } else {
                $this->markAsWrong($is);
            }
        }
    }

    /**
     * Mark essay questions as filled
     *
     * @param \Illuminate\Database\Eloquent\Collection $soal_terpilih
     * @return void
     */
    private function markUraianQuestions($soal_terpilih)
    {
        $uraian = $soal_terpilih->where('tipe_soal', 'uraian');

        foreach ($uraian as $ur) {
            if ($ur->jawaban) {
                $ur->status_jawaban = 'terisi';
                $ur->save();
            }
        }
    }

    /**
     * Calculate percentage score
     *
     * @param quiz_user $quiz_user
     * @return void
     */
    private function calculatePercentageScore(quiz_user $quiz_user)
    {
        $nilai_quiz = quiz::select('total_skor')
            ->where('id', $quiz_user->quiz_id)
            ->first()->total_skor;

        $quiz_user->nilai_persen = ($quiz_user->nilai_total / $nilai_quiz) * 100;

        return $quiz_user->nilai_persen;
    }    /**
     * Process quiz level information
     *
     * @param quiz_user $quiz_user
     * @return void
     */
    private function processQuizLevel(quiz_user $quiz_user)
    {
        return quiz::select('quiz.id', 'quiz.type', 'level.id as level_id', 'level.urutan_level')
            ->join('level', 'quiz.level_id', '=', 'level.id')
            ->where('quiz.id', $quiz_user->quiz_id)
            ->first();
    }

    /**
     * Mark a question as correct
     *
     * @param SoalTerpilih $soal
     * @return void
     */
    private function markAsCorrect(SoalTerpilih $soal)
    {
        $soal->status_jawaban = 'dinilai';
        $soal->status_jawaban_akhir = 'benar';
        $soal->nilai = $soal->skor_per_soal;
        $soal->save();
    }

    /**
     * Mark a question as wrong
     *
     * @param SoalTerpilih $soal
     * @return void
     */
    private function markAsWrong(SoalTerpilih $soal)
    {
        $soal->status_jawaban = 'dinilai';
        $soal->status_jawaban_akhir = 'salah';
        $soal->nilai = 0;
        $soal->save();
    }

    
}
