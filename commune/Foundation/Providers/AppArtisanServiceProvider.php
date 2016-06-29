<?php

namespace Commune\Foundation\Providers;

use Commune\Foundation\Console\OptimizeCommand;
use Commune\Foundation\Console\ProjectClearCommand;
use Commune\Foundation\Console\ProjectCreateCommand;
use Commune\Foundation\Console\ProjectOptimizeCommand;
use Illuminate\Foundation\Providers\ArtisanServiceProvider as ServiceProvider;

class AppArtisanServiceProvider extends ServiceProvider
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
        'ClearCompiled' => 'command.clear-compiled',
        'ClearResets' => 'command.auth.resets.clear',
        //'ConfigCache' => 'command.config.cache',
        //'ConfigClear' => 'command.config.clear',
        'Down' => 'command.down',
        'Environment' => 'command.environment',
        'KeyGenerate' => 'command.key.generate',
        'Optimize' => 'command.optimize',
        //'RouteCache' => 'command.route.cache',
        //'RouteClear' => 'command.route.clear',
        //'RouteList' => 'command.route.list',
        'Tinker' => 'command.tinker',
        'Up' => 'command.up',
        'ViewClear' => 'command.view.clear',
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        //'AppName' => 'command.app.name',
        'ProjectCreate' =>  'command.project.create',
        'ProjectOptimize'   =>  'command.project.optimize',
        'ProjectClear'      =>  'command.project.clear',
        'AuthMake' => 'command.auth.make',
        'CacheTable' => 'command.cache.table',
        'ConsoleMake' => 'command.console.make',
        //'ControllerMake' => 'command.controller.make',
        'EventGenerate' => 'command.event.generate',
        'EventMake' => 'command.event.make',
        'JobMake' => 'command.job.make',
        'ListenerMake' => 'command.listener.make',
        'MiddlewareMake' => 'command.middleware.make',
        'ModelMake' => 'command.model.make',
        'PolicyMake' => 'command.policy.make',
        'ProviderMake' => 'command.provider.make',
        'QueueFailedTable' => 'command.queue.failed-table',
        'QueueTable' => 'command.queue.table',
        'RequestMake' => 'command.request.make',
        'SeederMake' => 'command.seeder.make',
        'SessionTable' => 'command.session.table',
        //'Serve' => 'command.serve',
        'TestMake' => 'command.test.make',
        'VendorPublish' => 'command.vendor.publish',
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
    protected function registerOptimizeCommand()
    {
        $this->app->singleton('command.optimize', function ($app) {
            return new OptimizeCommand($app['composer']);
        });
    }

    protected function registerProjectCreateCommand()
    {
        $this->app->singleton('command.project.create',function($app){
            return new ProjectCreateCommand($app , $app['files'],$app['composer']);
        });
    }

    protected function registerProjectOptimizeCommand()
    {
        $this->app->singleton('command.project.optimize',function($app){
            return new ProjectOptimizeCommand($app,$app['files']);
        });
    }

    protected function registerProjectClearCommand()
    {
        $this->app->singleton('command.project.clear',function($app){
            return new ProjectClearCommand($app,$app['files']);
        });
    }
}
