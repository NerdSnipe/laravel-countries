<?php

namespace NerdSnipe\LaravelCountries;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Blade;
use NerdSnipe\LaravelCountries\Components\SelectLocation;
use NerdSnipe\LaravelCountries\Controllers\CityController;
use NerdSnipe\LaravelCountries\Controllers\CountryController;
use NerdSnipe\LaravelCountries\Controllers\StateController;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
class LaravelCountriesServiceProvider extends PackageServiceProvider
{
    public function bootOld()
    {
        Blade::componentNamespace('NerdSnipe\LaravelCountries\Components', 'laravel-countries');
        Blade::component('location-select', SelectLocation::class);
        // Publish the data files when the user runs `php artisan vendor:publish --tag=laravel-countries`
        $this->publishes([
            __DIR__.'/data/countries.json' => storage_path('app/laravel-countries/countries.json'),
            __DIR__.'/data/states.json' => storage_path('app/laravel-countries/states.json'),
            __DIR__.'/data/cities.json' => storage_path('app/laravel-countries/cities.json'),
        ], 'laravel-countries');

        $this->publishes([
            __DIR__.'/../config/laravel-countries.php' => config_path('laravel-countries.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/config/laravel-countries.php' => config_path('laravel-countries.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-countries');

        $this->app->router->group(['prefix' => 'laravel-countries'], function ($router) {
            $router->get('/countries', [CountryController::class, 'index'])->name('laravel-countries.countries.index');
            $router->get('/states/{country_id}', [StateController::class, 'index'])->name('laravel-countries.states.index');
            $router->get('/cities/{state_id}', [CityController::class, 'index'])->name('laravel-countries.cities.index');
        });

        AboutCommand::add('NerdSnipe Inc: Dynamic Country, State, City form elements', fn () => ['Version' => '1.0.0']);
    }

    /*
    "post-install-cmd": [
            "php artisan vendor:publish --provider=\"NerdSnipe\\LaravelCountries\\LaravelCountriesServiceProvider\" --tag=data"
        ],
        "post-update-cmd": [
            "php artisan vendor:publish --provider=\"NerdSnipe\\LaravelCountries\\LaravelCountriesServiceProvider\" --tag=config"
        ]
    ]
    */

    public function boot()
    {
        Blade::component(SelectLocation::class, 'location');
        Blade::componentNamespace('NerdSnipe\LaravelCountries\Components', 'laravel-countries');
        Blade::component('location-select', SelectLocation::class);

        $this->publishes([
            __DIR__.'/../config/laravel-countries.php' => config_path('laravel-countries.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'./resources/views/components/laravel-select.php' => base_path("app/View/Components/vendor/{$this->package->shortName()}"),
        ], 'components');

        $this->publishes([
            __DIR__.'/data/countries.json' => storage_path('app/laravel-countries/countries.json'),
            __DIR__.'/data/states.json' => storage_path('app/laravel-countries/states.json'),
            __DIR__.'/data/cities.json' => storage_path('app/laravel-countries/cities.json'),
        ], 'data');

        $this->loadViewComponentsAs('laravel-countries', [SelectLocation::class]);

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-countries');

        $this->app->router->group(['prefix' => 'laravel-countries'], function ($router) {
            $router->get('/countries', [CountryController::class, 'index'])->name('laravel-countries.countries.index');
            $router->get('/states/{country_id}', [StateController::class, 'index'])->name('laravel-countries.states.index');
            $router->get('/cities/{state_id}', [CityController::class, 'index'])->name('laravel-countries.cities.index');
        });

        AboutCommand::add('NerdSnipe Inc: Dynamic Country, State, City form elements', fn () => ['Version' => '1.0.0']);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-countries')
            ->hasConfigFile('laravel-countries')
            ->hasViews()
            ->hasRoute('web')
            ->hasViewComponent('nerd', SelectLocation::class);
    }
}
