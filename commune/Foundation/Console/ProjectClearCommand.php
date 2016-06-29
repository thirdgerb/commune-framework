<?php


namespace Commune\Foundation\Console;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Commune\Foundation\Console\Optimize\OptimizeProjects;
use Illuminate\Console\Command;

class ProjectClearCommand extends Command
{
    use OptimizeProjects;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'project:clear';

    protected $signature = 'project:clear {projectName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'undo optimization of one or all existing projects ';


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

        $this->info('success clear optimize at project : '.implode(',',array_keys($rounds)));
    }

    protected function runOptimizeAtProject($project, $artisan)
    {
        $this->info('run clear optimize at project : '.$project);
        system('/usr/bin/env php '.$artisan.' config:clear',$res);
        if($res){
            throw new \Exception('optimize '.$project.' config failed');
        }
        system('/usr/bin/env php '.$artisan.' route:clear',$res);
        if($res){
            throw new \Exception('optimize '.$project.' route failed');
        }
    }


}