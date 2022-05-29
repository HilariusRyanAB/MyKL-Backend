<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CreateEntryToken::class,
        Commands\EditStatusEntryToken::class,
        Commands\DeleteReportFile::class,
        Commands\SendNotification1::class,
        Commands\SendNotification2::class,
        Commands\SendNotification3::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('create:entryToken')->dailyAt('00:10');
        $schedule->command('update:entryToken')->dailyAt('00:00');
        $schedule->command('delete:report')->dailyAt('00:01');
        $schedule->command('create:sendNotification1')->dailyAt('00:15');
        $schedule->command('create:sendNotification2')->dailyAt('00:15');
        $schedule->command('create:sendNotification3')->dailyAt('00:15');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
