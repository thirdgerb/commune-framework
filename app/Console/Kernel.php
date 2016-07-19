<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Commune\Foundation\Bootstrap\DetectEnvironment',
        'Commune\Foundation\Bootstrap\LoadConfiguration',
        'Commune\Foundation\Bootstrap\ConfigureLogging',
        'Commune\Foundation\Bootstrap\HandleExceptions',
        'Commune\Foundation\Bootstrap\RegisterFacades',
        'Commune\Foundation\Bootstrap\SetRequestForConsole',
        'Commune\Foundation\Bootstrap\RegisterProviders',
        'Commune\Foundation\Bootstrap\BootProviders',
    ];

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
