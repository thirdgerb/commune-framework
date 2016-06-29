<?php

namespace Commune\Foundation\Providers;

use Commune\Foundation\Console\RouteCacheCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as ServiceProvider;
use Commune\Foundation\Console\ServeCommand;
use Commune\Foundation\Console\ConfigCacheCommand;

class ProjectArtisanServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        //'ClearCompiled' => 'command.clear-compiled',
        //'ClearResets' => 'command.auth.resets.clear',
        'ConfigCache' => 'command.config.cache',
        'ConfigClear' => 'command.config.clear',
        //'Down' => 'command.down',
        'Environment' => 'command.environment',
        //'KeyGenerate' => 'command.key.generate',
        //'Optimize' => 'command.optimize',
        'RouteCache' => 'command.route.cache',
        'RouteClear' => 'command.route.clear',
        'RouteList' => 'command.route.list',
        //'Tinker' => 'command.tinker',
        //'Up' => 'command.up',
        //'ViewClear' => 'command.view.clear',
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        //'AppName' => 'command.app.name',
        'AuthMake' => 'command.auth.make',
        //'CacheTable' => 'command.cache.table',
        'ConsoleMake' => 'command.console.make',
        'ControllerMake' => 'command.controller.make',
        //'EventGenerate' => 'command.event.generate',
        //'EventMake' => 'command.event.make',
        //'JobMake' => 'command.job.make',
        //'ListenerMake' => 'command.listener.make',
        'MiddlewareMake' => 'command.middleware.make',
        //'ModelMake' => 'command.model.make',
        //'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        //'QueueFailedTable' => 'command.queue.failed-table',
        //'QueueTable' => 'command.queue.table',
        //'RequestMake' => 'command.request.make',
        //'SeederMake' => 'command.seeder.make',
        //'SessionTable' => 'command.session.table',
        'Serve' => 'command.serve',
        //'TestMake' => 'command.test.make',
        //'VendorPublish' => 'command.vendor.publish',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands($this->commands);

        if(!$this->app->isProduction()){
            $this->registerCommands($this->devCommands);
        }
    }


    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerServeCommand()
    {
        $this->app->singleton('command.serve', function () {
            return new ServeCommand;
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerConfigCacheCommand()
    {
        $this->app->singleton('command.config.cache', function ($app) {
            return new ConfigCacheCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRouteCacheCommand()
    {
        $this->app->singleton('command.route.cache', function ($app) {
            return new RouteCacheCommand($app['files']);
        });
    }
}
