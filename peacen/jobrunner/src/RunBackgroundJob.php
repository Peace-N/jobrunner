<?php

namespace Peacen\JobRunner;

/**
 * Ths Class is an Invokable Class that runs as a function when executed
 */
class RunBackgroundJob
{
    /**
     * @var string
     */
    protected string $path;
    /**
     * @var string
     */
    protected string $class;
    /**
     * @var string
     */
    protected string $method;
    /**
     * @var array
     */
    protected array $params;

    /**
     * @param string $CLASS_NAME // Class Name //
     * @param string $method
     * @param $dir
     * @param ...$params
     */
    public function __construct(string $path, string $CLASS_NAME, string $method, ...$params)
    {
        $this->path = $path;
        $this->class = $CLASS_NAME;
        $this->method = $method;
        $this->params = $params;

        $this->validateRequirePath($path);
        $this->validateClass();
        $this->validateMethod();
        /// resolve OS independent path
        ///
        require($this->path);

        try {

            $pid = pcntl_fork();
            if ($pid == -1) {
                $this->genericMessage('FAILED STARTING RUNNER - COULD NOT START SEPARATE THREAD');
                exit("Error forking...\n");
            }
            else if ($pid == 0) {
                $this->execute_task($pid);
                exit();
            }

        } catch (\Exception $exception) {
            $this->genericMessage('FAILED STARTING RUNNER ' . $exception->getMessage());
        }

        ///check completion


    }

    public function execute_task($task_id) {
        $this->genericMessage('STARTING JOB RUNNER ON - ');
        $instance = new $this->class();
        $instance->{$this->method}(...$this->params);
        $this->genericMessage('COMPLETED JOB RUNNER ON - ');
    }

    /**
     * @param $path
     * @return false|string|void
     *
     */
    public function validateRequirePath($path)
    {
        try {
            if (!is_readable($path)) {
                return false;
            }

        } catch (\Exception $e) {
            $this->genericMessage('SUPPLIED PATH UNREADABLE - ');
        }
    }

    /**
     * @return false|void
     */
    public function validateClass()
    {

        /// Validate class Name
        if (!preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $this->class)) {
            $this->genericMessage('ERROR CHECK CLASS NAME - ');
            return false;
        }

        // check class existence
        if (!class_exists($this->class)) {
            $this->genericMessage('ERROR CHECK CLASS EXISTS - ');
        }


    }

    /**
     * @return false|void
     */
    public function validateMethod()
    {
        if (!preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $this->method)) {
            $this->genericMessage('ERROR CHECK METHOD NAME - ');
            return false;
        }

        // check method existence
        if (!function_exists($this->method)) {
            $this->genericMessage('ERROR CHECK METHOD EXISTS - ');
            return false;
        }

    }

    /**
     * @param $message
     * @return void
     */
    public function genericMessage($message) {
        $log = "{$message}: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
            "Attempt: " . ($this->class . ' | ' . $this->method) . PHP_EOL .
            "User: " . 'Authenticated User??' . PHP_EOL .
            "-------------------------" . PHP_EOL;
        file_put_contents(__DIR__ . '/logs/background_job_info_log.log', $log, FILE_APPEND);
    }


}
