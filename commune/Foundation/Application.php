<?php


namespace Commune\Foundation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application as Laravel;
use Illuminate\Foundation\ProviderRepository;

class Application extends Laravel
{
    protected $projectPath;


    public function __construct($basePath = null, $projectPath = null)
    {
        parent::__construct($basePath);

        if($projectPath){
            $this->setProjectPath($projectPath);
        }
        $this->bindPathsInContainer();
    }

    public function setPath($basePath = null, $projectPath =null)
    {
        if($basePath){
            $this->setBasePath($basePath);
        }
        if($projectPath){
            $this->setProjectPath($projectPath);
        }
        $this->bindPathsInContainer();
        return $this;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
    }

    public function setProjectPath($projectPath)
    {
        $this->projectPath = rtrim($projectPath, '\/');
    }


    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.project', $this->projectPath());
        $this->instance('path.lang', $this->langPath());

        $this->instance('path.config', $this->configPath());
        $this->instance('path.config.base', $this->baseConfigPath());

        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
    }


    public function projectPath()
    {
        return $this->projectPath ? : $this->basePath ;
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path()
    {
        return $this->projectPath().DIRECTORY_SEPARATOR.'app';
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @return string
     */
    public function bootstrapPath()
    {
        return $this->projectPath().DIRECTORY_SEPARATOR.'bootstrap';
    }

    public function baseBootstrapPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap';
    }


    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function baseConfigPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config';
    }


    public function configPath()
    {
        return $this->projectPath().DIRECTORY_SEPARATOR.'config';
    }


    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->projectPath().DIRECTORY_SEPARATOR.'public';
    }

    /**
     * Get the path to the cached "compiled.php" file.
     *
     * @return string
     */
    public function getCachedCompilePath()
    {
        return $this->baseBootstrapPath().'/cache/compiled.php';
    }


    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $manifestPath = $this->getCachedServicesPath();

        $appProviders = $this->config['app.providers'] ? : [];
        $projectProviders = $this->config['project.providers'] ? : [];
        $consoleProviders = $this->config['console.providers'] ? : [];

        $providers = array_unique(array_merge($appProviders , $projectProviders , $consoleProviders));

        (new ProviderRepository($this, new Filesystem(), $manifestPath))
                    ->load($providers);
    }


    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        $aliases = [
            'app'                  => ['Illuminate\Foundation\Application', 'Illuminate\Contracts\Container\Container', 'Illuminate\Contracts\Foundation\Application'],
            'auth'                 => ['Illuminate\Auth\AuthManager', 'Illuminate\Contracts\Auth\Factory'],
            'auth.driver'          => ['Illuminate\Contracts\Auth\Guard'],
            'blade.compiler'       => ['Illuminate\View\Compilers\BladeCompiler'],
            'cache'                => ['Illuminate\Cache\CacheManager', 'Illuminate\Contracts\Cache\Factory'],
            'cache.store'          => ['Illuminate\Cache\Repository', 'Illuminate\Contracts\Cache\Repository'],
            'config'               => ['Illuminate\Config\Repository', 'Illuminate\Contracts\Config\Repository'],
            'cookie'               => ['Illuminate\Cookie\CookieJar', 'Illuminate\Contracts\Cookie\Factory', 'Illuminate\Contracts\Cookie\QueueingFactory'],
            'encrypter'            => ['Illuminate\Encryption\Encrypter', 'Illuminate\Contracts\Encryption\Encrypter'],
            'db'                   => ['Illuminate\Database\DatabaseManager'],
            'db.connection'        => ['Illuminate\Database\Connection', 'Illuminate\Database\ConnectionInterface'],
            'events'               => ['Illuminate\Events\Dispatcher', 'Illuminate\Contracts\Events\Dispatcher'],
            'files'                => ['Illuminate\Filesystem\Filesystem'],
            'filesystem'           => ['Illuminate\Filesystem\FilesystemManager', 'Illuminate\Contracts\Filesystem\Factory'],
            'filesystem.disk'      => ['Illuminate\Contracts\Filesystem\Filesystem'],
            'filesystem.cloud'     => ['Illuminate\Contracts\Filesystem\Cloud'],
            'hash'                 => ['Illuminate\Contracts\Hashing\Hasher'],
            'translator'           => ['Illuminate\Translation\Translator', 'Symfony\Component\Translation\TranslatorInterface'],
            'log'                  => ['Illuminate\Log\Writer', 'Illuminate\Contracts\Logging\Log', 'Psr\Log\LoggerInterface'],
            'mailer'               => ['Illuminate\Mail\Mailer', 'Illuminate\Contracts\Mail\Mailer', 'Illuminate\Contracts\Mail\MailQueue'],
            'auth.password'        => ['Illuminate\Auth\Passwords\PasswordBrokerManager', 'Illuminate\Contracts\Auth\PasswordBrokerFactory'],
            'auth.password.broker' => ['Illuminate\Auth\Passwords\PasswordBroker', 'Illuminate\Contracts\Auth\PasswordBroker'],
            'queue'                => ['Illuminate\Queue\QueueManager', 'Illuminate\Contracts\Queue\Factory', 'Illuminate\Contracts\Queue\Monitor'],
            'queue.connection'     => ['Illuminate\Contracts\Queue\Queue'],
            'queue.failer'         => ['Illuminate\Queue\Failed\FailedJobProviderInterface'],
            'redirect'             => ['Illuminate\Routing\Redirector'],
            'redis'                => ['Illuminate\Redis\Database', 'Illuminate\Contracts\Redis\Database'],
            'request'              => ['Illuminate\Http\Request', 'Symfony\Component\HttpFoundation\Request'],
            'router'               => ['Illuminate\Routing\Router', 'Illuminate\Contracts\Routing\Registrar'],
            'session'              => ['Illuminate\Session\SessionManager'],
            'session.store'        => ['Illuminate\Session\Store', 'Symfony\Component\HttpFoundation\Session\SessionInterface'],
            'url'                  => ['Illuminate\Routing\UrlGenerator', 'Illuminate\Contracts\Routing\UrlGenerator'],
            'validator'            => ['Illuminate\Validation\Factory', 'Illuminate\Contracts\Validation\Factory'],
            'view'                 => ['Illuminate\View\Factory', 'Illuminate\Contracts\View\Factory'],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }


    public function isBaseProject()
    {
        return $this->basePath === $this->projectPath;
    }

    public function isProduction()
    {
        return $this['env'] == 'production';
    }
}