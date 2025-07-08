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
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    public function user(Request $request)
    {

        $search = $request->input('search');
        $paginate = $request->input('paginate', 10);

        $user = User::select('id', 'name')
            ->where('role', 'user')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate($paginate);

        return view('admin_page.user_activity.index', compact('user'));
    }

    public function activity(string $id)
    {

        $today = Carbon::now();
        $dayInMonth = $today->daysInMonth;
        $dates = [];

        for ($i = 1; $i <= $dayInMonth; $i++) {
            $dates[] = $today->copy()->day($i)->format('d');
        }

        $activity = DailyActivity::select('id', 'activity')
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


        return view('admin_page.user_activity.activity', compact('dates', 'activity', 'user', 'userActivity', 'monthlyActivity'));
    }

    // public function generateMonthlyReport()
    // {

    //     try {

    //         $month = carbon::now()->month;
    //         $year = carbon::now()->year;

    //         $users = User::select('id')
    //             ->where('role', 'user')
    //             ->get();

    //         $activities = DailyActivity::select('id')
    //             ->get();

    //         foreach ($users as $user) {
    //             foreach ($activities as $activity) {

    //                 $monthlyActivity = Monthly_activity::where('id_user', $user->id)
    //                     ->where('id_activity', $activity->id)
    //                     ->where('bulan', $month)
    //                     ->where('tahun', $year)
    //                     ->first();

    //                 if (!$monthlyActivity) {
    //                     Monthly_activity::create([
    //                         'id_user' => $user->id,
    //                         'id_activity' => $activity->id,
    //                         'bulan' => $month,
    //                         'tahun' => $year,
    //                         'total' => 0
    //                     ]);
    //                 }
    //             }
    //         }

    //         return redirect()->back()->with('success', 'Generate Monthly Activity Success');
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function getActivityUser(){
        try {
            $user = auth()->user();
            $today = Carbon::now();
            $day = $today->format('Y-m-d');

         $user_activity = User_activity::select('user_activity.id', 'daily_activity.activity','user_activity.status','user_activity.tanggal_pengerjaan', 'user_activity.id_activity')
            ->join('daily_activity', 'user_activity.id_activity', '=', 'daily_activity.id')
            ->where('user_activity.id_user', $user->id)
            ->whereDate('user_activity.tanggal_pengerjaan', $day)
            ->get();

            // dd($user_activity, $day);

            $monthlyActivity = Monthly_activity::query()
            ->where('id_user', $user->id)
            ->where('bulan', $today->month)
            ->where('tahun', $today->year)
            ->join('daily_activity', 'monthly_activity.id_activity', '=', 'daily_activity.id')
            ->select([
                'monthly_activity.id',
                'daily_activity.activity',
                'monthly_activity.jumlah_aktivitas',
                'monthly_activity.id_activity'
            ])
            ->get();

            return view('user_page.daily_activity.daily_activity_form', compact('user_activity','user', 'monthlyActivity'));

        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userActivity()
    {
        try {
            $user = Auth::user();
            $today = Carbon::now();
            $dayInMonth = $today->daysInMonth;
            $dates = [];

            for ($i = 1; $i <= $dayInMonth; $i++) {
                $dates[] = $today->copy()->day($i)->format('d');
            }

            $activity = DailyActivity::select('id', 'activity')
                ->get();

            $userActivity = User_activity::where('id_user', $user->id)
                ->whereMonth('created_at', $today->month)
                ->whereYear('created_at', $today->year)
                ->get();

            $monthlyActivity = Monthly_activity::query()
                ->where('id_user', $user->id)
                ->where('bulan', $today->month)
                ->where('tahun', $today->year)
                ->join('daily_activity', 'monthly_activity.id_activity', '=', 'daily_activity.id')
                ->select([
                    'monthly_activity.id',
                    'daily_activity.activity',
                    'monthly_activity.jumlah_aktivitas',
                    'daily_activity.id as activity_id'
                ])
                ->get();


            // dd($monthlyActivity);
            return view('user_page.daily_activity.daily_activity', compact('dates', 'activity', 'user', 'userActivity', 'monthlyActivity'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateDailyActivity(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:user_activity,id',
                'status' => 'required|boolean',
            ]);

            $activity = User_activity::findOrFail($request->id);

            $oldStatus = $activity->status;

            $activity->status = $request->status;
            $activity->save();

            $monthlyActivity = Monthly_activity::where('id_user', $activity->id_user)
                ->where('id_activity', $activity->id_activity)
                ->where('bulan', Carbon::now()->month)
                ->where('tahun', Carbon::now()->year)
                ->first();

            if ($oldStatus != $activity->status && $monthlyActivity) {
                if ($activity->status) {
                    $monthlyActivity->jumlah_aktivitas += 1;
                } else {
                    $monthlyActivity->jumlah_aktivitas = max(0, $monthlyActivity->jumlah_aktivitas - 1);
                }

                $monthlyActivity->save();
            }

            return response()->json([
                'success' => true,
                'id_activity' => $activity->id_activity,
                'jumlah_aktivitas' => $monthlyActivity->jumlah_aktivitas,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
