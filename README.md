# Laravel Airbrake Codebase

This is a Laravel 5 package for [Codebase](https://www.codebasehq.com/) Exceptions handler using [Airbrake PHP package](https://github.com/airbrake/phpbrake).

This package will configure an instance of `Airbrake\Notifier` with an project ID and key from Codebase Exceptions handler.

## Install

Require it via composer.

```
composer require matriphe/laravel-airbrake-codebase
```

Add package to list of service providers in `config/app.php` file.

```php
<?php
    'providers' => [
        ...
        Matriphe\Codebase\CodebaseServiceProvider::class,
        ...
    ],
```

Publish and fill out the `config/codebase.php` file with your project ID, key, and ignored environments.

```
php artisan vendor:publish --provider="Matriphe\Codebase\CodebaseServiceProvider"
```

## Ignoring Exceptions

To ignore some exceptions sent to Codebase Exceptions, just add the ignored exceptions in `app/Exceptions/Handler.php` in `$dontReport` section of your application.

```php
class Handler extends ExceptionHandler
{
   /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        ...
        YourIgnoredException::class,
        ...
    ];
    
    ...
```