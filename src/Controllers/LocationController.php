<?php

namespace NerdSnipe\LaravelCountries\Controllers;

use App\Http\Controllers\Controller;
use NerdSnipe\LaravelCountries\Models\City;
use NerdSnipe\LaravelCountries\Models\Country;
use NerdSnipe\LaravelCountries\Models\State;

/**
 * The Laravel Countries Location.
 *
 * This is used by the Facade to deliver data outside the select elements
 *
 * @author NerdSnipe <hello@nerdsnipe.cc>
 * @copyright Copyright (c) NerdSnipe Inc.
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @link https://github.com/nerdsnipe/laravel-countries
 * @link https://www.nerdsnipe.cc
 */
class LocationController extends Controller
{
    public function getCountries()
    {
        return response()->json(Country::getCountries());
    }

    public function getStates($countryId)
    {
        $state = new State();
        $states = $state->where('country_id', $countryId)
            ->orderBy('name', 'asc')
            ->get()
            ->pluck('name', 'id');

        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $city = new City();
        $cities = $city->where('state_id', $stateId)
            ->orderBy('name', 'asc')
            ->get()
            ->pluck('name', 'id');

        return response()->json($cities);
    }

    public function getCityById($id)
    {
        $model = new City();
        $rows = $model->where('id', $id)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            });

        return response()->json($rows[0]);
    }

    public function getStateById($id)
    {
        $model = new State();
        $rows = $model->where('id', $id)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            });

        return response()->json($rows[0]);
    }

    public static function getCountryById($countryId)
    {
        $country = new Country();
        $countries = $country->getCountries();

        $country = $countries->firstWhere('id', $countryId);
        $rows = [];
        if ($country) {
            $rows = [
                'id' => $country->id,
                'name' => $country->name,
            ];
        }

        return response()->json($rows);
    }
}
