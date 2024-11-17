<?php

namespace Peacen\JobRunner;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Peacen\JobRunner\commands\InitiateCommand;

class JobRunnerServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('helpers', function ($app) {
            return require __DIR__.'/helpers/background_helpers.php';
        });

    }

    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                InitiateCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/config/runner-config.php' => config_path('runner-config.php'),
        ]);

    }
}
