<!-- [![Build Status](https://github.com/lagdo/laravel-facades/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/lagdo/laravel-facades/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lagdo/laravel-facades/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/lagdo/laravel-facades/?branch=main)
[![StyleCI](https://styleci.io/repos/418488513/shield?branch=main)](https://styleci.io/repos/418488513)
[![codecov](https://codecov.io/gh/lagdo/laravel-facades/branch/main/graph/badge.svg?token=HERKC60CC1)](https://codecov.io/gh/lagdo/laravel-facades) -->

[![Latest Stable Version](https://poser.pugx.org/lagdo/laravel-facades/v/stable)](https://packagist.org/packages/lagdo/laravel-facades)
[![Total Downloads](https://poser.pugx.org/lagdo/laravel-facades/downloads)](https://packagist.org/packages/lagdo/laravel-facades)
[![License](https://poser.pugx.org/lagdo/laravel-facades/license)](https://packagist.org/packages/lagdo/laravel-facades)

Facades for Laravel services
============================

With this package, Laravel services can be called using service facades, with static method syntax.

It may be surprising to implement service facades for Laravel, since the same feature is already provided. Laravel has even invented the service facades!
But unlike Laravel, the service facades implemented here are portable across different frameworks, thanks to the use of [this package](https://github.com/lagdo/facades).

### Installation

Install the package with `composer`.

```bash
composer require lagdo/laravel-facades
```

Register the `Lagdo\Laravel\Facades\FacadesBundle` bundle in the `config/bundles.php` file.

### Usage

A service facade inherits from the `Lagdo\Facades\AbstractFacade` abstract class, and implements the `getServiceIdentifier()` method, which must return the id of the corresponding service in the service container.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Facades\AbstractFacade;

/**
 * @extends AbstractFacade<MyService>
 */
class MyFacade extends AbstractFacade
{
    /**
     * @inheritDoc
     */
    protected static function getServiceIdentifier(): string
    {
        return MyService::class;
    }
}
```

The methods of the `App\Services\MyService` service can now be called using the `App\Facades\MyFacade` facade, like this.

```php
class TheService
{
    public function theMethod()
    {
        MyFacade::myMethod();
    }
}
```

Instead of this.

```php
class TheService
{
    /**
     * @var MyService
     */
    protected $myService;

    public function __construct(MyService $myService)
    {
        $this->myService = $myService;
    }

    public function theMethod()
    {
        $this->myService->myMethod();
    }
}
```

The `@extends AbstractFacade<MyService>` phpdoc will prevent errors during code analysis with [PHPStan](https://phpstan.org/), and allow code completion on calls to service facades in editors.

### Getting the service instance

The `instance()` method of a service facade returns the instance of the linked service.

```php
class TheService
{
    public function theMethod()
    {
        $service = MyFacade::instance();
        $service->myMethod();
    }
}
```

### The `Lagdo\Facades\ServiceInstance` trait

By default, each call to a service facade method will also call the service container.
The service instance can be saved in the facade after the first call to the service container, using the `Lagdo\Facades\ServiceInstance` trait.
The next calls with return the service instance without calling the service container.

```php
namespace App\Facades;

use App\Services\MyService;
use Lagdo\Facades\AbstractFacade;
use Lagdo\Facades\ServiceInstance;

/**
 * @extends AbstractFacade<MyService>
 */
class MyFacade extends AbstractFacade
{
    use ServiceInstance;

    /**
     * @inheritDoc
     */
    protected static function getServiceIdentifier(): string
    {
        return MyService::class;
    }
}
```

> [!IMPORTANT]
> The `Lagdo\Facades\ServiceInstance` trait *must* be defined in the final service facade class, and not inherited by a service facade.

The service container is called only once in this example code.

```php
    MyFacade::myMethod1(); // Calls the service container
    MyFacade::myMethod2(); // Doesn't call the service container
    MyFacade::myMethod1(); // Doesn't call the service container
```

### Provided facades

Some service facades are included by default in this package.

#### Logger

This facade requires that the `Psr\Log\LoggerInterface` id is defined and bound to the logger in the service container.

```php
use Lagdo\Facades\Logger;

Logger::info($message, $vars);
```

Contribute
----------

- Issue Tracker: github.com/lagdo/laravel-facades/issues
- Source Code: github.com/lagdo/laravel-facades

License
-------

The package is licensed under the 3-Clause BSD license.
