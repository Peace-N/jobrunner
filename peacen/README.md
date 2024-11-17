<p align="center"><a href="https://github.com/Peace-N" target="_blank">
<img src="https://media.licdn.com/media/AAYQAQSOAAgAAQAAAAAAAB-zrMZEDXI2T62PSuT6kpB6qg.png" width="200" ></a></p>

<p align="center">
<a href="https://github.com/Peace-N"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
</p>

## About Job Runner

Job Runner is a laravel package, installation is super easy you will need to check the following:
- Laravel version 11
- PHP8.2+

## Installation Instructions

- Create a new folder in the root of your laravel app and call it packages
- Clone this package inside the packages folder

### Add repository & require to your main composer.json file in the root of your laravel application
````
    "require": {
        "peacen/jobrunner": "dev-main"
    },
    
    "repositories": [
        {
            "type": "path",
            "url": "./packages/peacen/jobrunner"
        }
    ]
````

### Run composer update
````
    composer update
````

### Register Service Provider
````
    open file:  app\bootstrap
    add: \Peacen\JobRunner\JobRunnerServiceProvider::class
````

### Run Composer Update
````
   composer update
````

### runBackgroundJob helper function

The helper function can be used anywhere to run a background function:

```runBackgroundJob($path, $class, $method, ...$args)```

### running the background job using command line

You can use any class in any absolute path an example is a class with a method and params as below
````
sudo php artisan peace:run /Users/peacecoinvest/Herd/jobs/TestJob.php TestJob initTest peace ngara 24
````

### configuring options
````
    Open packages/peacen/jobrunner and in config open runner-config.php
    All configuraation options have been listed, you can change values as per the use case and update the config values
````

### Error Logs
````
Error logs are under the  \Peacen\JobRunner\logs 
````
### Info Logs

````
Info logs are under the  \Peacen\JobRunner\logs 
````
### Runner Admin UI

Im progress ..

### RoadMap

1. The future roadmap would be to create a queing system using either redis or mysql.
2. Advance functions todo::make it callable from shell_exec 
3. Add PHP Unit Tests to the package
4. Add an Admin UI

