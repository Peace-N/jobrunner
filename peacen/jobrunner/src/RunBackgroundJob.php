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

            $instance = new $this->class(); ////////named domain or namespace e.g \m\c\myclass.php
            $instance->{$this->method}(...$this->params);
            //call_user_func_array(array($instance, "MethodName"), $myArgs); // can be used as well

            $log = "JUB RUNNER STARTED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . PHP_EOL .
                "User: " . 'Authenticated User??' . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_job_info_log.log', $log, FILE_APPEND);

        } catch (\Exception $exception) {
            //retry attempts --- delays --- priorities

            $log = "JUB RUNNER FAILED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . '|' . PHP_EOL .
                "Reason: " . $exception->getMessage() . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_jobs_errors.log', $log, FILE_APPEND);
        }

        ///check completion


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
            $log = "JUB RUNNER FAILED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . '|' . PHP_EOL .
                "Reason: " . 'Invalid File Path | File not readable' . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_jobs_errors.log', $log, FILE_APPEND);
        }
    }

    /**
     * @return false|void
     */

    /**
     * @return false|void
     */
    public function validateClass()
    {


        /// Validate class Name
        if (!preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $this->class)) {
            $log = "JUB RUNNER FAILED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . '|' . PHP_EOL .
                "Reason: " . 'Class Name Resolution Problems - Check Class Name' . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_jobs_errors.log', $log, FILE_APPEND);
            return false;
        }

        // check class existence
        if (!class_exists($this->class)) {
            $log = "JUB RUNNER FAILED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . '|' . PHP_EOL .
                "Reason: " . 'Class Name does not exist - Check Class Name' . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_jobs_errors.log', $log, FILE_APPEND);
        }


    }

    /**
     * @return false|void
     */
    public function validateMethod()
    {
        if (!preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $this->method)) {
            $log = "JUB RUNNER FAILED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . '|' . PHP_EOL .
                "Reason: " . 'Method Name Resolution Problems - Check Method Name' . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_jobs_errors.log.log', $log, FILE_APPEND);
            return false;
        }

        // check method existence
        if (!function_exists($this->method)) {
            $log = "JUB RUNNER FAILED: CLASS:" . $this->class . ' -  METHOD: ' . $this->method . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
                "Attempt: " . ($this->class . ' | ' . $this->method) . '|' . PHP_EOL .
                "Reason: " . 'Function Name does not exist - Check Method Name' . PHP_EOL .
                "-------------------------" . PHP_EOL;
            file_put_contents(__DIR__ . '/logs/background_jobs_errors.log.log', $log, FILE_APPEND);

            return false;
        }

    }


}
