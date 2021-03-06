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
        // Application backups
        $schedule->command('backup:clean')->daily()->at('01:00')->withoutOverlapping()->onOneServer();
        $schedule->command('backup:run')->daily()->at('02:00')->withoutOverlapping()->onOneServer();
        $schedule->command('backup:monitor')->daily()->at('03:00')->withoutOverlapping()->onOneServer();
        $schedule->command('disposable:update')->weekly();
        $schedule->command('make:sitemap')->daily()->at('04:00')->withoutOverlapping()->onOneServer();
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
