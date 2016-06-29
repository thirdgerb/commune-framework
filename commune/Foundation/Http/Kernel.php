<?php

namespace Commune\Foundation\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    protected $bootstrappers = [
        'Commune\Foundation\Bootstrap\DetectEnvironment',
        'Commune\Foundation\Bootstrap\LoadConfiguration',
        'Commune\Foundation\Bootstrap\ConfigureLogging',
        'Commune\Foundation\Bootstrap\HandleExceptions',
        'Commune\Foundation\Bootstrap\RegisterFacades',
        'Commune\Foundation\Bootstrap\RegisterProviders',
        'Commune\Foundation\Bootstrap\BootProviders',
    ];

}
