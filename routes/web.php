<?php

use Illuminate\Support\Facades\Route;
use NerdSnipe\LaravelCountries\Controllers\CityController;
use NerdSnipe\LaravelCountries\Controllers\CountryController;
use NerdSnipe\LaravelCountries\Controllers\StateController;

Route::get('/laravel-countries/countries', [CountryController::class, 'index'])->name('laravel-countries.countries.index');
Route::get('/laravel-countries/states/{country_id}', [StateController::class, 'index'])->name('laravel-countries.states.index');
Route::get('/laravel-countries/cities/{state_id}', [CityController::class, 'index'])->name('laravel-countries.cities.index');
