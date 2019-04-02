<?php
    
return [
    
    /*
    |--------------------------------------------------------------------------
    | Enable Codebase Exceptions
    |--------------------------------------------------------------------------
    |
    | If set to true, exceptions will be sent to Codebase Exceptions.
    | To prevent development exceptions sent to Codebase Exceptions, 
    | by default this option is set to false. 
    | Use .env to manually set to true in production.
    |
    */

    'enabled' => env('CODEBASE_ENABLED', false),
    
    /*
    |--------------------------------------------------------------------------
    | Codebase Exceptions API ID and Key
    |--------------------------------------------------------------------------
    |
    | Please refer to your Codebase Exception tab in your project.
    |
    */

    'id'  => env('CODEBASE_PROJECT_ID', ''),
    'key' => env('CODEBASE_API_KEY', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Codebase Exceptions Host
    |--------------------------------------------------------------------------
    |
    | Mostly people do not change this. But if you're using other service
    | that use Airbrake specification, you can change and fit to your
    | service host.
    |
    */

    'host' => 'exceptions.codebasehq.com',

    'enabled' => env('environment', false),
];