<?php


namespace Commune\Foundation\Console\Optimize;


trait OptimizeProjects
{
    protected function getRoundsFromProjects($projects){
        $name = $this->argument('projectName');
        if(!$name){
            $rounds = $projects;
        } elseif(isset($projects[$name])){
            $rounds = [
                $name   =>  $projects[$name],
            ];
        } else {
            $rounds =  [];
        }
        return $rounds;
    }

    protected function getProjectsFromComposer()
    {

        $data = json_decode($this->file->get($this->getComposerPath()),true);
        $projects = [];
        $defaultArtisan = $this->laravel->basePath().'/artisan';
        foreach($data['autoload']['psr-4'] as $project => $path) {
            $artisanPlace = $this->getArtisanPlace($path);
            if($artisanPlace != $defaultArtisan && file_exists($artisanPlace)){
                $offset    = trim($project,'\\');
                $projects[$offset] = $artisanPlace;
            }
        }
        return $projects;
    }

    protected function getComposerPath()
    {
        return $this->laravel->basePath().DIRECTORY_SEPARATOR.'composer.json';
    }

    protected function getArtisanPlace($path)
    {
        $path = $path ? '/'.$path.'/../' : '';
        return realpath(str_replace('//','/',$this->laravel->basePath().$path.'/artisan'));
    }

}