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
        Commands\CreateDataBilling::class,
        Commands\EditStatusBilling::class,
        //Commands\SendBillingOwner::class,
        //Commands\SendBillingTenant::class,
        //Commands\DeleteBillingOwner::class,
        //Commands\DeleteBillingTenant::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('create:billing')->monthlyOn(1, '01:00');
        //$schedule->command('send:billingO')->monthlyOn(5, '14:00');
        //$schedule->command('send:billingT')->monthlyOn(5, '16:00');
        $schedule->command('update:billing')->monthlyOn(26, '01:00');
        //$schedule->command('delete:billingO')->monthlyOn(26, '20:00');
        //$schedule->command('delete:billingT')->monthlyOn(26, '22:00');
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
