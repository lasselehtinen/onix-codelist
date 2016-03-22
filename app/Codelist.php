<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

class Codelist extends Model
{
    use AlgoliaEloquentTrait;

    public static $autoIndex = true;
    public static $autoDelete = true;

    public $algoliaSettings = [
        'attributesToIndex' => [
            'description',
            'number',
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number'];

    /**
     * Get the Codes for the Codelist.
     */
    public function codes()
    {
        return $this->hasMany('App\Code');
    }

    /**
     * Get the Elements for the Codelist.
     */
    public function elements()
    {
        return $this->hasMany('App\Element');
    }
}
