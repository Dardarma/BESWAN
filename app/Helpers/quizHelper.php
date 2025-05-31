<?php

namespace App\Helpers;

use App\Models\quiz;
use App\Models\type_soal;
use App\Models\quiz_user;
use App\Models\SoalTerpilih;
use App\Models\Level_Murid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class quizHelper
{
    public static function activeQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $quiz_soal = type_soal::where('quiz_id', $quizId)->get();

        foreach ($quiz_soal as $item) {
            if ($item->jumlah_soal_now >= $item->jumlah_soal) {
                $quizComplete = true;
            } else {
                $quizComplete = false;
            }
        }
        // dd($quizComplete);

        $quiz->is_active = $quizComplete;
        $quiz->save();
    }    
    
    public static function changeStatusQuiz($quizUserId)
    {
        try {
            // Count scored questions
            $soalDinilai = SoalTerpilih::where('quiz_user_id', $quizUserId)
                ->where('status_jawaban', 'dinilai')
                ->count();
            
            // Count total questions for this quiz attempt
            $totalSoal = SoalTerpilih::where('quiz_user_id', $quizUserId)
                ->count();
            
            // Get quiz_user record
            $quiz_user = quiz_user::findOrFail($quizUserId);
            
            // If all questions have been scored, update status
            if ($soalDinilai == $totalSoal && $totalSoal > 0) {
                $quiz_user->status = 'dinilai';
                $quiz_user->save();
                
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('Error in changeStatusQuiz: ' . $e->getMessage());
            return false;
        }
    }

    public static function addExp($quiz_user_id, $nilai_persen,$user_id)
    {
       
        // dd($nilai_persen);
        $quiz_user = quiz_user::findOrFail($quiz_user_id);
        $quiz = quiz::findOrFail($quiz_user->quiz_id);

        $sudah_lulus = quiz_user::where('user_id', $user_id)
            ->where('quiz_id', $quiz->id)
            ->where('nilai_persen', '>=', 70)
            ->exists();

        // dd($sudah_lulus);

        if (!$sudah_lulus && $nilai_persen >= 70) {
            $level_murid = Level_Murid::where('id_siswa', $user_id)
                ->where('id_level', $quiz->level_id)
                ->first();

            $level_murid->exp += 1;
            // dd($level_murid->toArray());
            $level_murid->save();
        }
    }


}
