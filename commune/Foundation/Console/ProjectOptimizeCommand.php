<?php


namespace Commune\Foundation\Console;

use Commune\Foundation\Console\Optimize\OptimizeProjects;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;

class ProjectOptimizeCommand extends Command
{
    use OptimizeProjects;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:optimize';

    protected $signature = 'project:optimize {projectName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'optimize one or all existing projects';

    protected $laravel;

    protected $file;

    public function __construct(Application $app , Filesystem $file)
    {
        parent::__construct();
        $this->laravel = $app;
        $this->file = $file;
    }

    public function handle()
    {
        $projects = $this->getProjectsFromComposer();
        $rounds   = $this->getRoundsFromProjects($projects);
        if(! count($rounds)){
            $this->error('projects not exists!');
        }

        foreach($rounds as $project => $artisan){
            $this->runOptimizeAtProject($project , $artisan);
        }

        $this->info('success optimize at project : '.implode(',',array_keys($rounds)));
    }

    protected function runOptimizeAtProject($project, $artisan)
    {
        $this->info('run optimize at project : '.$project);
        system('/usr/bin/env php '.$artisan.' config:cache',$res);
        if($res){
            throw new \Exception('optimize '.$project.' config failed');
        }
        system('/usr/bin/env php '.$artisan.' route:cache',$res);
        if($res){
            throw new \Exception('optimize '.$project.' route failed');
        }
    }

}