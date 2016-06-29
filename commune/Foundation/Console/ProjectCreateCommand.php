<?php


namespace Commune\Foundation\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application as App;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Psy\Util\Json;
use Symfony\Component\Finder\Finder;

class ProjectCreateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:create';

    protected $signature = 'project:create {projectName}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a project in projects directory';

    protected $file;

    protected $laravel;

    protected $composer;

    public function __construct(App $app , Filesystem $file , Composer $composer)
    {
        $this->laravel  = $app;
        $this->file     = $file;
        $this->composer = $composer;
        parent::__construct();
    }

    public function handle()
    {
        if(in_array($this->projectName(),['App','Commune'])){
            $this->error('project name should not be App|Commune| php key words');
            return;
        }

        if($this->projectPathExists()){
            $this->error('project "'.$this->projectName().'" exists! change project name or delete the existing project');
            return;
        }
        $this->initProject();
        $this->resetNamespace();
        $this->rewriteComposer();

        $this->composer->dumpAutoloads();
        $this->info('composer dump autoload');

        $this->initEnv();

        $this->info('done! please check new project files');
    }


    protected function projectPathExists()
    {
        return (bool)realpath($this->projectPath());
    }

    protected function projectName()
    {
        return $this->argument('projectName');
    }


    protected function initProject()
    {
        $this->info('start init project files');
        $files = $this->getStubFiles();
        foreach($files as $file){
            $this->moveFileToProject($file);
        }
        $this->info('finish project files initialization');
    }

    protected function moveFileToProject(\SplFileInfo $file)
    {
        $realPath = $file->getRealPath();
        $newPath  = str_replace($this->getStubPath() ,$this->projectPath(),$realPath);
        $path = pathinfo($newPath);
        if(isset($path['extension']) && $path['extension'] == 'git'){
            $newPath = $path['dirname'].DIRECTORY_SEPARATOR.'.git'.$path['filename'];
        }

        if(!realpath($path['dirname'])){
            $this->file->makeDirectory($path['dirname'],0755,true);
        }
        $this->file->copy($realPath,$newPath);
        $this->info("copy",'vv');
        $this->warn('   '.$realPath,'vv');
        $this->warn('   '.$newPath,'vv');
    }



    protected function projectPath()
    {
        return $this->laravel->basePath().DIRECTORY_SEPARATOR.'projects'.DIRECTORY_SEPARATOR.$this->getProjectDir();
    }

    protected function projectAppPath()
    {
        return $this->projectPath().DIRECTORY_SEPARATOR.'app';
    }

    protected function bootstrapPath()
    {
        return $this->projectPath().DIRECTORY_SEPARATOR.'bootstrap/init.php';
    }


    protected function getProjectDir()
    {
        return strtolower($this->projectName());
    }

    protected function getStubPath()
    {
        return realpath($this->laravel->storagePath().'/framework/projects/stub/');
    }

    /**
     * Get the path to the given configuration file.
     *
     * @param  string  $name
     * @return string
     */
    protected function getConfigPath($name)
    {
        return $this->projectPath().'/config/'.$name.'.php';
    }


    protected function getStubFiles()
    {
        return $this->file->allFiles($this->getStubPath());
    }

    protected function sayAbort()
    {
        $this->info('mission abort');
    }

    protected function rewriteComposer()
    {

        $data = json_decode($this->file->get($this->getComposerPath()),true);
        $data['autoload']['psr-4'][$this->projectName().'\\'] = 'projects/'.$this->getProjectDir().'/app/';
        $this->file->copy($this->getComposerPath(), $this->getComposerPath().time());
        $this->file->put($this->getComposerPath(), Json::encode($data,JSON_PRETTY_PRINT));
        $this->info('added autoload to composer');
    }

    protected function getComposerPath()
    {
        return $this->laravel->basePath().DIRECTORY_SEPARATOR.'composer.json';
    }

    /**
     * Replace the given string in the given file.
     *
     * @param  string  $path
     * @param  string|array  $search
     * @param  string|array  $replace
     * @return void
     */
    protected function replaceIn($path, $search, $replace)
    {
        $this->file->put($path, str_replace($search, $replace, $this->file->get($path)));
    }


    /**
     * Replace the App namespace at the given path.
     *
     * @param  string  $path
     * @return void
     */
    protected function replaceNamespace($path)
    {
        $search = [
            'namespace WWW;',
            'WWW\\',
        ];

        $replace = [
            'namespace '.$this->projectName().';',
            $this->projectName().'\\',
        ];

        $this->replaceIn($path, $search, $replace);
    }

    protected function resetNamespace()
    {
        $this->setBootstrapNamespaces();
        $this->setAppDirectoryNamespace();
        $this->setConfigNamespaces();
        $this->info('set new project namespace to '.$this->projectName());
    }

    protected function setBootstrapNamespaces()
    {
        $search = [
            'WWW\\Http',
            'WWW\\Console',
        ];

        $replace = [
            $this->projectName().'\\Http',
            $this->projectName().'\\Console',
        ];

        $this->replaceIn($this->bootstrapPath(), $search, $replace);
    }

    protected function setAppDirectoryNamespace()
    {
        $files = Finder::create()
                    ->in($this->projectAppPath())
                    ->name('*.php');

        foreach ($files as $file) {
            $this->replaceNamespace($file->getRealPath());
        }
    }

    /**
     * Set the namespace in the appropriate configuration files.
     *
     * @return void
     */
    protected function setConfigNamespaces()
    {
        $this->setConsoleConfigNamespaces();
    }

    protected function setConsoleConfigNamespaces()
    {
        $search = [
            'WWW\\Providers',
        ];

        $replace = [
            $this->projectName().'\\Providers',
        ];

        $this->replaceIn($this->getConfigPath('project'), $search, $replace);
    }


    protected function initEnv()
    {
        $envPath = $this->laravel->basePath();
        $envFile = $this->laravel->environmentFile();
        if(!file_exists($envPath.'/'.$envFile)){
            $envFile = '.env.example';
        }

        $env  = $envPath.'/'.$envFile;
        $this->file->copy($env,$this->projectPath().'/'.$envFile);
        $this->info('copy '.$envFile.' to project');
    }
}