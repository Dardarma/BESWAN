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
    protected $signature = 'user-activity:generate';
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
                    $exists = User_activity::where('id_user', $user->id)
                        ->where('id_activity', $activity->id)
                        ->whereDate('created_at', Carbon::today())
                        ->exists();
            
                    if (!$exists) {
                        User_activity::create([
                            'id_user' => $user->id,
                            'id_activity' => $activity->id,
                            'status' => false,
                            'tanggal_pengerjaan' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
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
