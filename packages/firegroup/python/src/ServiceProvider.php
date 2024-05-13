<?php

namespace Firegroup\Python;


use Firegroup\Python\Commands\RunPythonCommand;
use Firegroup\Python\Services\Python;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom($this->packagePath() . '/config/python.php', 'python');

        $this->app->singleton('python', function () { return new Python();});
    }

    public function boot()
    {
//        $this->publishes([
//            $this->packagePath() . '/config/python.php' => config_path('python.php')
//        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    private function packagePath()
    {
        return __DIR__ . '/..';
    }

    private function registerCommands()
    {
        $this->commands([
            RunPythonCommand::class
        ]);
    }

}
