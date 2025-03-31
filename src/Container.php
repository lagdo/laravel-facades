<?php

/**
 * Container.php
 * PSR-11 compatible proxy to the service container
 *
 * @package laravel-facades
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2025 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/lagdo/laravel-facades
 */

namespace Lagdo\Laravel\Facades;

use Psr\Container\ContainerInterface;

use function app;

final class Container implements ContainerInterface
{
    /**
     * @inheritDoc
     */
    public function has(string $serviceId): bool
    {
        return app()->bound($serviceId);
    }

    /**
     * @inheritDoc
     */
    public function get(string $serviceId)
    {
        return app()->make($serviceId);
    }
}
