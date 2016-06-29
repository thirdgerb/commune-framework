<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\BrowserConsoleHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //开发环境中启动
        $this->bootWhenLocal();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }


    protected function bootWhenLocal()
    {
        //开发环境
        if(!$this->app->isLocal()) {
            return;
        }

        //日志
        $logger = Log::getMonolog();
        $logger->pushHandler(new BrowserConsoleHandler());

        //DB事件
        DB::listen(function($query){
            Log::info('sql :'.$query->sql , ['binding' => $query->bindings,'time' => $query->time]);
        });

    }
}
