<?php

namespace NerdSnipe\LaravelCountries\Controllers;

use App\Http\Controllers\Controller;
use NerdSnipe\LaravelCountries\Models\Country;

/**
 * The Laravel Countries Controller.
 *
 * This returns the JSON results for the dynamic country select element.
 *
 * @author NerdSnipe <hello@nerdsnipe.cc>
 * @copyright Copyright (c) NerdSnipe Inc.
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @link https://github.com/nerdsnipe/laravel-countries
 * @link https://www.nerdsnipe.cc
 */
class CountryController extends LocationController
{
    public function index()
    {
        $countries = Country::getCountries();

        return response()->json($countries);
    }

    public function show($id)
    {
        $country = Country::find($id);

        return response()->json($country);
    }

    public function findByCode($code)
    {
        $country = Country::findByCode($code);

        return response()->json($country);
    }
}
