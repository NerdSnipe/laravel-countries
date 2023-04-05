<?php

namespace NerdSnipe\LaravelCountries\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NerdSnipe\LaravelCountries\Models\City;

/**
 * The Laravel Countries City Controller.
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
class CityController extends LocationController
{
    public function index(Request $request, $stateId)
    {
        $city = new City();
        $cities = $city->where('state_id', $stateId)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            })
            ->values()
            ->toArray();

        return response()->json($cities);
    }
}
