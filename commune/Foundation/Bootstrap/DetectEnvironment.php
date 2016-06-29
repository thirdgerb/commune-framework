<?php

namespace Commune\Foundation\Bootstrap;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Illuminate\Contracts\Foundation\Application;

class DetectEnvironment
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        if (! $app->configurationIsCached()) {
            $this->checkForSpecificEnvironmentFile($app);

            try {
                $path = $app->environmentPath();
                $file = $app->environmentFile();
                if(!file_exists($path.'/'.$file)){
                    $path = $app->basePath();
                }
                (new Dotenv($path, $file))->load();
            } catch (InvalidPathException $e) {
                //
            }
        }
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    protected function checkForSpecificEnvironmentFile($app)
    {
        if (! env('APP_ENV')) {
            return;
        }

        $file = $app->environmentFile().'.'.env('APP_ENV');

        if (file_exists($app->environmentPath().'/'.$file)) {
            $app->loadEnvironmentFrom($file);
        }
    }
}
