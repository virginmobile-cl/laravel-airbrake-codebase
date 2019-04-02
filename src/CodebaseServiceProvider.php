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
            __DIR__.'/../config/airbrake.php' => $this->configPath('airbrake.php'),
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
                'projectId' => config('airbrake.id'),
                'projectKey' => config('airbrake.key'),
                'host' => config('airbrake.host'),
                'appVersion' => config('airbrake.appVersion'),
                'environment' => config('airbrake.environment'),
            ]);

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
    
    protected function getEnvKeyFromLine($envLine)
    {
        return trim(current(explode('=', $envLine)));
    }

    protected function setEnvName(&$notice)
    {
        $notice['context']['environment'] = env('APP_ENV');
    }
    
    protected function configPath($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}