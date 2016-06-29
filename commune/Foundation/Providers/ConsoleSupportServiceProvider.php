<?php

namespace Commune\Foundation\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Contracts\Foundation\Application as App;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Illuminate\Console\ScheduleServiceProvider',
        'Illuminate\Database\MigrationServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Queue\ConsoleServiceProvider',
    ];

    public function __construct(App $app)
    {
        parent::__construct($app);
        if($app->isProduction()){
            $this->providers = [
                'Illuminate\Console\ScheduleServiceProvider',
                //'Illuminate\Database\MigrationServiceProvider',
                //'Illuminate\Database\SeedServiceProvider',
                'Illuminate\Queue\ConsoleServiceProvider',
            ];
        }
    }
}
