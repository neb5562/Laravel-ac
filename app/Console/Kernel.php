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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:verificationemails')->everyTwoMinutes();
        $schedule->command('send:guestVerificationEmails')->everyTwoMinutes();
        $schedule->command('send:passwordresets')->everyMinute();
        $schedule->command('send:welcomemails')->everyFiveMinutes();
        $schedule->command('update:counts')->hourly();
        $schedule->command('new:ptoducts')->everyThirtyMinutes();
        $schedule->command('new:blogs')->hourlyAt(15);
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
