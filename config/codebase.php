<?php
    
return [
    
    // Globally enable airbrake
    'enabled' => env('CODEBASE_ENABLED', true),
    
    // Environments to ignore errors
    'ignore_environments' => [
        'local',
        'testing',
        'development',
    ],
    
    // API Key
    'id'  => env('CODEBASE_PROJECT_ID', ''),
    'key' => env('CODEBASE_API_KEY', ''),
    
    // Connection to the Codebase
    'host' => 'exceptions.codebasehq.com',
];