<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateDailyUserActivity::class,
        Commands\GenerateMonthlyActivityReport::class,
    ];
    
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('user-activity:generate')->everyMinute();
        $schedule->command('report:monthly-activity')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
