# Laravel and Lumen Airbrake Codebase

This is a Laravel 5 and Lumen package for [Codebase](https://www.codebasehq.com/) Exceptions handler using [Airbrake PHP package](https://github.com/airbrake/phpbrake).

This package will configure an instance of `Airbrake\Notifier` with an project ID and key from Codebase Exceptions handler.

## Install

Require it via composer.

```
composer require matriphe/laravel-airbrake-codebase
```

### Laravel

For Laravel version below 5.4, add package to list of service providers in `config/app.php` file. No need to add this manually in Laravel 5.5 since it used auto package discovery.

```php
'providers' => [
    Matriphe\Codebase\CodebaseServiceProvider::class,
],
```

Publish and fill out the `config/codebase.php` file with your project ID, key, and ignored environments.

```
php artisan vendor:publish --provider="Matriphe\Codebase\CodebaseServiceProvider"
```

### Lumen

Register package by adding this line in `bootstrap/app.php`.

```php
$app->register(Matriphe\Codebase\CodebaseServiceProvider::class);
```

Manually copy the config file to your `config` path. If `config` path doesn't exists, make it first.

```
cp vendor/matriphe/laravel-airbrake-codebase/config/codebase.php config/
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
        YourIgnoredException::class,
    ];
```