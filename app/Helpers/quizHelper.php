<?php

namespace App\Helpers;
use App\Models\quiz;
use App\Models\type_soal;

class quizHelper
{
    public static function activeQuiz($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $quiz_soal = type_soal::where('quiz_id', $quizId)->get();

        foreach($quiz_soal as $item){
           if($item->jumlah_soal_now >= $item->jumlah_soal){
                $quizComplete = true;
            }else{
                $quizComplete = false;
            }
        }
        // dd($quizComplete);

        $quiz->is_active = $quizComplete;
        // dd($quiz->is_active);
        $quiz->save();
    }
}