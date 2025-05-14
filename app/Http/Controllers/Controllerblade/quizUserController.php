<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\quiz;
use App\Models\type_soal;
use App\Models\quiz_user;

use function PHPSTORM_META\type;

class quizUserController extends Controller
{
    public function getQuizList(Request $request)
    {
    
        $paginate = $request->input('paginate', 10);

        $level = auth()->user()->levels->pluck('id')->toArray();
        
        // dd($level);

        $quiz = quiz::select('quiz.id','materi.judul as judul_materi','quiz.judul as judul_quiz','quiz.waktu_pengerjaan','quiz_user.nilai')
            ->join('materi','quiz.materi_id','=','materi.id')
            ->leftJoin('quiz_user',function($join){
                $join->on('quiz.id','=','quiz_user.quiz_id')
                ->where('quiz_user.user_id',auth()->user()->id)
                ->where('quiz_user.updated_at', function($query){
                    $query->selectRaw('MAX(updated_at)')
                    ->from('quiz_user')
                    ->whereColumn('quiz_user.quiz_id', 'quiz.id')
                    ->where('quiz_user.user_id', auth()->user()->id);
                });
            })
            ->where('quiz.is_active',1)
            ->where('quiz.type','posttest')
            ->where('materi.id_level',$level)
            ->paginate($paginate);

            foreach ($quiz as $q){
                $q-> type_soal = type_soal::where('quiz_id',$q->id)->select('id','tipe_soal','jumlah_soal')->get();
            }

        // dd($quiz);

        return view('user_page.quiz_user.quiz_list',compact('quiz','q'));
    }

    public function getQuizUser(string $id_quiz){
        // dd($id_quiz);
        try{
            
            $user = auth()->user()->id;

            $quiz = quiz::select('quiz.id','materi.judul as judul_materi','quiz.judul as judul_quiz','quiz.waktu_pengerjaan')
                ->join('materi','quiz.materi_id','=','materi.id')
                ->where('quiz.id',$id_quiz)
                ->first();

            // dd($quiz);

           $quiz->type_soal = type_soal::where('quiz_id', $quiz->id)
                ->select('id', 'tipe_soal', 'jumlah_soal')
                ->get();


            $quiz_user = quiz_user::select('nilai','jawaban_benar','jawaban_salah')
                ->where('quiz_id',$id_quiz)
                ->where('user_id',$user)
                ->get();

            dd($quiz_user);

            return view();
        }catch(\Exception $e){
            return redirect()->back()->with('error','Gagal mendapatkan data\n'.$e->getMessage());
        }
    }
}  