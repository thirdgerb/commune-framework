<?php

namespace Commune\Foundation\Console;

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

}
