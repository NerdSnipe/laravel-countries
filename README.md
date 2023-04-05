# Laravel Countries Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nerdsnipe/laravel-countries.svg?style=flat-square)](https://packagist.org/packages/nerdsnipe/laravel-countries)
[![Total Downloads](https://img.shields.io/packagist/dt/nerdsnipe/laravel-countries.svg?style=flat-square)](https://packagist.org/packages/nerdsnipe/laravel-countries)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A Laravel package for working with countries, states, provinces, and cities. Use this package to easily add a 
dynamic country, state and cities select element series to your Laravel application. All required data is available
in the included JSON files which are ```NOT``` imported to your database.

## Requirements

- PHP >= 8.1
- Laravel >= 9.0

## Installation

You can install the package via composer:

```bash
composer require nerdsnipe/laravel-countries
```

You ```must``` publish the package config file.

```bash
php artisan vendor:publish --provider="NerdSnipe\LaravelCountries\LaravelCountriesServiceProvider" --tag="config"
```

This will publish the ```config/laravel-countries.php``` file. 

Set the ```script_stack``` and ```style_stack```
to reflect where to place script and css elements within your view or layout.

```php
return [
    
    /**
     * The default country to select if none set
     */
    'default_country' => 39,

    /**
     * Where should the component place the JavaScript within your view
     */
    'script_stack' => 'post-app-scripts',

    /**
     * Where should the component place the CSS styles within your view
     */
    'style_stack' => 'post-app-css',
];

```

Publish the package's data (json) files.

```bash
php artisan vendor:publish --provider="NerdSnipe\LaravelCountries\LaravelCountriesServiceProvider" --tag="data"
```

This will copy the countries.json, states.json, and cities.json files to your storage/app/laravel-countries directory.

## Example usage

The component relies on providing the id and name of the 
select element ```field_name``` and has the optional values for country, state and city. 

This example sets the name attribute of the component to "location", and passes in the IDs of the selected country, 
state, and city as props, which will pre-select those options when the component is rendered. 

The component will then dynamically update the state and city options based on the selected country and state.

Optionally (very useful for the end-user) you can use select2 and set the styles using the ```props['select2', 'dark']``` set either (or both) of them to true
to enable the search feature and select2 styling.

```php
<x-laravel-countries::select-location
                field_name="location"
                class="col-4"
                dark=""
                select2=""
                placeholder="{!! __('Select Country') !!}"
                :selected-country="$user->country_id"
                :selected-state="$user->state_id"
                :selected-city="$user->city_id"
    />
```

**Note:** Based on the ```field_name``` setting (above) access the submitted values as:

```php 
$request->location['country_id'] $request->location['state_id'] $request->location['city_id'] 
```

Use the Facade to get access to the underlying data, remember these are large 
data-sets

```php
$countriesConnection = LaravelCountries::getCountries(); // Massive Data
$statesCollection = LaravelCountries::getStates($countryID); // Massive Data
$citiesCollection = LaravelCountries::getCities($stateID); // Massive Data
```

Will return collections as JSON. If you want to use the data you can extract it from the collection

```php
$countryData = $countries->getData();
$stateData = $statesCollection->getData();
$cityData = $citiesCollection->getData();
```

After using the country, state and city dynamic selector the data will also be available in the cache.

```php
Cache::get("laravel-countries.countries")
Cache::get("laravel-countries.cities.{$selectedState}")
Cache::get("laravel-countries.states.{$selectedCountry}")
```

## TODO
* Add function to enable a default country, city and state
* Add ability to focus countries by ```region``` as an option
* Add the use of ```native``` in place of name to return country names in their native language
* Add a gate/middleware to the routes. Because the country select series are likely to be used on 
registration pages, there is currently no middleware attached to the routes. This exposes the country, state and city json 
results without any sort of can:view authorization
* Add a method to cache all states and cities through the Facade (```LaravelCountries:cacheAll()```)

## Credits

* [Countries, States, Cities Database](https://github.com/dr5hn/countries-states-cities-database)

* [Laravel Package Tools](https://github.com/spatie/laravel-package-tools)

A special thanks and shout-out to the team at [Spatie](https://github.com/spatie) we appreciate all you do for the Laravel 
open-source community. You have inspired us to extract useful functionality we have created for internal and client applications 
and make them available as an open source package. This is the first such package.

## License
The Laravel Countries Package is open-sourced software licensed under the MIT license.

## Change Log

### V1.1

* Added ```getCityById```, ```getStateById```, ```getCountryById``` to the Facade
* Added ability to hide the labels
* Added ability to stretch (full-width) the select input

### Data available in Countries

```json
[
    {
        "id": 1,
        "name": "Afghanistan",
        "iso3": "AFG",
        "iso2": "AF",
        "numeric_code": "004",
        "phone_code": "93",
        "capital": "Kabul",
        "currency": "AFN",
        "currency_name": "Afghan afghani",
        "currency_symbol": "؋",
        "tld": ".af",
        "native": "افغانستان",
        "region": "Asia",
        "subregion": "Southern Asia",
        "timezones": [
            {
                "zoneName": "Asia\/Kabul",
                "gmtOffset": 16200,
                "gmtOffsetName": "UTC+04:30",
                "abbreviation": "AFT",
                "tzName": "Afghanistan Time"
            }
        ],
        "translations": {
            "kr": "아프가니스탄",
            "pt-BR": "Afeganistão",
            "pt": "Afeganistão",
            "nl": "Afghanistan",
            "hr": "Afganistan",
            "fa": "افغانستان",
            "de": "Afghanistan",
            "es": "Afganistán",
            "fr": "Afghanistan",
            "ja": "アフガニスタン",
            "it": "Afghanistan",
            "cn": "阿富汗",
            "tr": "Afganistan"
        },
        "latitude": "33.00000000",
        "longitude": "65.00000000",
        "emoji": "🇦🇫",
        "emojiU": "U+1F1E6 U+1F1EB"
    }
]
```

### Data Available in States

```json
[
    {
        "id": 3901,
        "name": "Badakhshan",
        "country_id": 1,
        "country_code": "AF",
        "country_name": "Afghanistan",
        "state_code": "BDS",
        "type": null,
        "latitude": "36.73477250",
        "longitude": "70.81199530"
    }
]
```

### Data available in Cities

```json
[
    {
        "id": 52,
        "name": "Ashkāsham",
        "state_id": 3901,
        "state_code": "BDS",
        "state_name": "Badakhshan",
        "country_id": 1,
        "country_code": "AF",
        "country_name": "Afghanistan",
        "latitude": "36.68333000",
        "longitude": "71.53333000",
        "wikiDataId": "Q4805192"
    }
]
```
