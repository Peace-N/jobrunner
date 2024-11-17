<?php

namespace Peacen\JobRunner\commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Peacen\JobRunner\RunBackgroundJob;

class InitiateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    const OS_WINDOWS = 1;
    const OS_NIX = 2;
    const OS_OTHER = 3;

    protected $signature = 'peace:run {path} {class} {method} {params*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a Custom Job Command';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $command =  new RunBackgroundJob($this->argument('path'), $this->argument('class'), $this->argument('method'), ...$this->argument('params'));
        $this->info($this->argument('class') . $this->argument('method') . implode('-', $this->argument('params')));

    }

}

