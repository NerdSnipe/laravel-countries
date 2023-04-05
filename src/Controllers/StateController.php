<?php

namespace NerdSnipe\LaravelCountries\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NerdSnipe\LaravelCountries\Models\State;

/**
 * The Laravel Countries State Controller.
 *
 * This returns the JSON results for the dynamic state select element.
 *
 * @author NerdSnipe <hello@nerdsnipe.cc>
 * @copyright Copyright (c) NerdSnipe Inc.
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @link https://github.com/nerdsnipe/laravel-countries
 * @link https://www.nerdsnipe.cc
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $country_id
 * @property-read \NerdSnipe\LaravelCountries\Models\Country $country
 */
class StateController extends LocationController
{
    public function index(Request $request, $countryId)
    {
        $state = new State();

        $states = $state->where('country_id', $countryId)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            })
            ->values()
            ->toArray();

        return response()->json($states);
    }
}
