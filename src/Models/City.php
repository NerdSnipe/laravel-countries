<?php

namespace NerdSnipe\LaravelCountries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * City model representing a city or town within a state
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
 * @property int $state_id
 * @property string $state_code
 * @property string $state_name
 * @property int $country_id
 * @property string $country_code
 * @property string $country_name
 * @property float $latitude
 * @property float $longitude
 * @property string $wikiDataId
 */
class City extends Model
{
    protected $jsonFile;

    public $jsonData;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Replace 'data.json' with the path to your JSON file
        // $this->jsonFile = storage_path('app/data.json');
        // $this->jsonData = json_decode(file_get_contents($this->jsonFile), true);
        $this->jsonData = json_decode(Storage::get('laravel-countries/cities.json'));
    }

    // To retrieve all records
    public static function all($columns = ['*'])
    {
        $jsonData = json_decode(Storage::get('laravel-countries/cities.json'));

        return new Collection($jsonData);
    }

// To find a record by its primary key
    public function find($id, $columns = ['*'])
    {
        foreach ($this->jsonData as $record) {
            if ($record['id'] == $id) {
                return new Collection([$record]);
            }
        }

        return null;
    }

// Basic 'where' query
    // Modify the where method
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (func_num_args() == 2) {
            [$value, $operator] = [$operator, '='];
        }

        $this->jsonData = array_filter($this->jsonData, function ($record) use ($column, $operator, $value) {
            switch ($operator) {
                case '=':
                    return $record->$column == $value;
                case '>':
                    return $record->$column > $value;
                case '<':
                    return $record->$column < $value;
                    // Add more cases for other operators if needed
                default:
                    return false;
            }
        });

        return $this;
    }

// Modify the orderBy method
    public function orderBy($column, $direction = 'asc')
    {
        $sortedData = $this->jsonData;

        usort($sortedData, function ($a, $b) use ($column, $direction) {
            if ($a->$column == $b->$column) {
                return 0;
            }

            if ($direction == 'asc') {
                return $a->$column < $b->$column ? -1 : 1;
            } else {
                return $a->$column > $b->$column ? -1 : 1;
            }
        });

        $this->jsonData = $sortedData;

        return $this;
    }

// Add a get method
    public function get()
    {
        return new Collection($this->jsonData);
    }
}
