<?php

namespace NerdSnipe\LaravelCountries;

use NerdSnipe\LaravelCountries\Models\Country;

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
class LaravelCountries
{
    protected static $config = [];

    public static function setConfig(array $config)
    {
        static::$config = $config;
    }

    public static function getConfig(string $key = null)
    {
        if ($key) {
            return static::$config[$key] ?? null;
        }

        return static::$config;
    }

    public static function getDefaultCountry()
    {
        return static::getConfig('default_country');
    }

    public static function getCountries()
    {
        return Country::all();
    }

    // Other utility methods...
}
