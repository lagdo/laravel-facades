<?php

/**
 * FacadesServiceProvider.php
 *
 * @package laravel-facades
 * @author Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @copyright 2025 Thierry Feuzeu <thierry.feuzeu@gmail.com>
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause License
 * @link https://github.com/lagdo/laravel-facades
 */

namespace Lagdo\Laravel\Facades;

use Illuminate\Support\ServiceProvider;
use Lagdo\Facades\ContainerWrapper;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        ContainerWrapper::setContainer(new Container());
    }
}
