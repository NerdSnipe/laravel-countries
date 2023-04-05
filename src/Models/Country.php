<?php

namespace NerdSnipe\LaravelCountries\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Represents a country with a unique identifier and various properties
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
 * @property string $iso3
 * @property string $iso2
 * @property string $numeric_code
 * @property string $phone_code
 * @property string $capital
 * @property string $currency
 * @property string $currency_name
 * @property string $currency_symbol
 * @property string $tld
 * @property string $native
 * @property string $region
 * @property string $subregion
 * @property array $timezones
 * @property array $translations
 * @property string $latitude
 * @property string $longitude
 * @property string $emoji
 * @property string $emojiU
 */
class Country extends Collection
{
    protected $items;

    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    public static function getCountries()
    {
        $json = Storage::get('laravel-countries/countries.json');

        return collect(json_decode($json, true))->map(function ($item) {
            return (object) $item;
        });
    }

    public function find($id)
    {
        return $this->firstWhere('id', $id);
    }

    public function findByCode($code)
    {
        return $this->firstWhere('code', $code);
    }
}
