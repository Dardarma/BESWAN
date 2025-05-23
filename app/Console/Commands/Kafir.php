<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\DailyActivity;
use App\Models\Monthly_activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Kafir extends Command
{
    protected $signature = 'report:monthly-activity';
    protected $description = 'Generate monthly activity report for all users';

    public function handle()
    {
        try {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;

            $users = User::select('id')
                ->where('role', 'user')
                ->get();

            $activities = DailyActivity::select('id')->get();

            foreach ($users as $user) {
                foreach ($activities as $activity) {
                    $monthlyActivity = Monthly_activity::where('id_user', $user->id)
                        ->where('id_activity', $activity->id)
                        ->where('bulan', $month)
                        ->where('tahun', $year)
                        ->first();

                    if (!$monthlyActivity) {
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

            $this->info('Generate Monthly Activity Success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
