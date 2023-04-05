<?php

namespace NerdSnipe\LaravelCountries\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use NerdSnipe\LaravelCountries\Models\City;
use NerdSnipe\LaravelCountries\Models\Country;
use NerdSnipe\LaravelCountries\Models\State;

/**
 * Laravel Countries Select Elements Component.
 *
 * This is the Blade component that renders the 3 select elements in the view
 *
 * @author NerdSnipe <hello@nerdsnipe.cc>
 * @copyright Copyright (c) NerdSnipe Inc.
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @link https://github.com/nerdsnipe/laravel-countries
 * @link https://www.nerdsnipe.cc
 */
class SelectLocation extends Component
{
    public $countries;

    public array $states = [];

    public array $cities = [];

    public int|null $selectedCountry;

    public int|null $selectedState;

    public int|null $selectedCity;

    public string $name;

    public function __construct($name = 'location', $selectedCountry = null, $selectedState = null, $selectedCity = null)
    {
        $this->name = $name;
        $this->selectedCountry = $selectedCountry;
        $this->selectedState = $selectedState;
        $this->selectedCity = $selectedCity;

        $this->countries = Cache::rememberForever('laravel-countries.countries', function () {
            $country = new Country();

            return collect($country->getCountries())->pluck('name', 'id', 'native')->prepend(__('Select Country'), '');
        });

        if (! is_null($selectedCountry)) {
            $this->states = Cache::rememberForever("laravel-countries.states.{$selectedCountry}", function () use ($selectedCountry) {
                $state = new State();

                return $state->where('country_id', $selectedCountry)
                    ->orderBy('name', 'asc')
                    ->get()
                    ->map(function ($item) {
                        return ['id' => $item->id, 'name' => $item->name];
                    })
                    ->values()
                    ->toArray();
            });

        }

        if (! is_null($selectedState)) {
            $this->cities = Cache::rememberForever("laravel-countries.cities.{$selectedState}", function () use ($selectedState) {
                $city = new City();

                return $city->where('state_id', $selectedState)
                    ->orderBy('name', 'asc')
                    ->get()
                    ->map(function ($item) {
                        return ['id' => $item->id, 'name' => $item->name];
                    })
                    ->values()
                    ->toArray();
            });

        }
    }

    public function render()
    {
        // dd( $this->countries );

        // Log::info('LocationSelect render method called');
        return view('laravel-countries::components.location-select', [
            'countries' => $this->countries,
            'states' => $this->states,
            'cities' => $this->cities,
            'selectedCountry' => $this->selectedCountry,
            'selectedState' => $this->selectedState,
            'selectedCity' => $this->selectedCity,
            'name' => $this->name,
        ]);
    }

}
