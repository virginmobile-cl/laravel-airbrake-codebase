<?php
    
namespace Matriphe\Codebase;

use Airbrake\Notifier;
use Illuminate\Support\ServiceProvider;

class CodebaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/codebase.php' => config_path('codebase.php'),
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Airbrake\Instance', function ($app) {
            $airbrake = new Notifier([
                'projectId'  => config('codebase.id'),
                'projectKey' => config('codebase.key'),
                'host' => config('codebase.host'),
            ]);
            
            $airbrake->addFilter(function ($notifier) {
                $this->setEnvName($notifier);
                
                foreach ($this->getEnvKeys() as $envKey) {
                    $this->filterEnvKey($notifier, $envKey);
                }
                
                return $notice;
            });
            
            return $airbrake;
        });
        
        $handler = $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler');
        
        $this->app->instance(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            new CodebaseExceptionHandler($handler, $this->app)
        );
    }
    protected function filterEnvKey(&$notice, $envKey)
    {
        if (isset($notice['environment'][$envKey])) {
            $notice['environment'][$envKey] = 'FILTERED';
        }
    }
    
    protected function getEnvFile()
    {
        $filePath = $this->app->environmentPath().'/'.$this->app->environmentFile();
        $envFile = @file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        return is_array($envFile) ? $envFile : [];
    }
    
    protected function getEnvKeyFromLine($envLine)
    {
        return trim(current(explode('=', $envLine)));
    }
    
    protected function getEnvKeys()
    {
        $envFile = $this->getEnvFile();
        $envKeys = array_map([$this, 'getEnvKeyFromLine'], $envFile);
        
        return $envKeys;
    }
    
    protected function setEnvName(&$notice)
    {
        $notice['context']['environment'] = env('APP_ENV');
    }
}