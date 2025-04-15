<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\DailyActivity;
use App\Models\User_activity;
use Carbon\Carbon;

class GenerateDailyUserActivity extends Command
{
    protected $signature = 'generate:user-activity-daily';
    protected $description = 'Generate user daily activities for all users';

    public function handle()
    {
        try {
            $users = User::select('id', 'name')
                ->where('role', 'user')
                ->get();

            $activities = DailyActivity::select('id', 'activity')->get();
            $today = Carbon::now();

            foreach ($users as $user) {
                foreach ($activities as $activity) {
                    $userActivity = User_activity::where('id_user', $user->id)
                        ->where('id_activity', $activity->id)
                        ->whereDate('created_at', $today->toDateString())
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

            $this->info('Generate Daily Activity Success');
        } catch (\Exception $e) {
            Log::error('GenerateDailyUserActivity: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }

        return 0;
    }
}
