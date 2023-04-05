<?php

namespace NerdSnipe\LaravelCountries\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Laravel Countries package.
 *
 * This package provides a set of models, controllers, and views for managing countries, states, and cities. Use
 *  the view component to create te country, state, city select drop-down series.
 *
 * @author NerdSnipe <hello@nerdsnipe.cc>
 * @copyright Copyright (c) NerdSnipe Inc.
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @link https://github.com/nerdsnipe/laravel-countries
 * @link https://www.nerdsnipe.cc
 */
class LaravelCountries extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NerdSnipe\LaravelCountries\Controllers\LocationController::class;
    }
}
