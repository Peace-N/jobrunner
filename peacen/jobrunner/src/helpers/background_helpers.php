<?php

use Peacen\JobRunner\RunBackgroundJob;

/**
 * @param $path
 * @param $class
 * @param $method
 * @param ...$args
 * @return RunBackgroundJob
 */

if (! function_exists('app_path')) {
    function runBackgroundJob($path, $class, $method, ...$args)
    {
        return new RunBackgroundJob($path, $class, $method, ...$args);
    }
}

///todo::make it callable from shell_exec
