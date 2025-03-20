<?php

namespace App\Http\Controllers\Controllerblade;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\Monthly_activity;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserActivityController extends Controller
{
    public function user(Request $request){
        
        $search = $request->input('search');
        $paginate = $request->input('paginate', 10);

        $user = User::select('id','name')
            ->where('role', 'user')
            ->when($search, function($query, $search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->paginate($paginate);

        return view('admin_page.user_activity.index', compact('user'));
    }

    public function activity(string $id){

        $today = Carbon::now();
        $dayInMonth= $today->daysInMonth;
        $dates = [];

        for($i = 1 ; $i <= $dayInMonth; $i++){
            $dates[] = $today->copy()->day($i)->format('d');
        }

        $activity = DailyActivity::select('id','activity')
        ->get();

        $userActivity = User_activity::where('id_user', $id)
        ->whereMonth('created_at', $today->month)
        ->whereYear('created_at', $today->year)
        ->get();

        $monthlyActivity = Monthly_activity::query()
        ->where('id_user', $id) 
        ->where('bulan', $today->month) 
        ->where('tahun', $today->year) 
        ->join('daily_activity', 'monthly_activity.id_activity', '=', 'daily_activity.id') 
        ->select([
            'monthly_activity.id', 
            'daily_activity.activity', 
            'monthly_activity.jumlah_aktivitas'
        ]) 
        ->get(); 
    

        $user = User::findOrFail($id, ['name']);
        
        return view('admin_page.user_activity.activity', compact('dates','activity','user','userActivity','monthlyActivity'));  
    }

    public function generateDailyActivity()
    {   
        try {
            $users = User::select('id', 'name')
                ->where('role', 'user')
                ->get();
            $activities = DailyActivity::select('id', 'activity')
                ->get();
            $today = Carbon::now();
    
            foreach ($users as $user) {
                foreach ($activities as $activity) {
                    $userActivity = User_activity::where('id_user', $user->id)
                        ->where('id_activity', $activity->id)
                        ->whereMonth('created_at', $today)
                        ->first();
    
                    if (!$userActivity) {
                        User_activity::create([
                            'id_user' => $user->id,
                            'id_activity' => $activity->id,
                            'status' => false,
                            'created_at' => $today
                        ]);
                    }
                }
            }

    
            return redirect()->back()->with('success', 'Generate Daily Activity Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function generateMonthlyReport(){
    
    try{

        $month = carbon::now()->month;
        $year = carbon::now()->year;
    
        $users = User::select('id')
            ->where('role', 'user')
            ->get();
        
        $activities = DailyActivity::select('id')
            ->get();
    
        foreach ($users as $user) {
            foreach ($activities as $activity){
    
                $monthlyActivity = Monthly_activity::where('id_user', $user->id)
                    ->where('id_activity', $activity->id)
                    ->where('bulan', $month)
                    ->where('tahun', $year)
                    ->first();
    
                if(!$monthlyActivity){
                    Monthly_activity::create([
                        'id_user' => $user->id,
                        'id_activity' => $activity->id,
                        'bulan' => $month,
                        'tahun' => $year,
                        'total' => 0
                    ]);
                }
    
            }
        }

        return redirect()->back()->with('success', 'Generate Monthly Activity Success');
    }catch(\Exception $e){
        Log::error($e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
    }
    
}
}