<?php

namespace App;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Codelist extends Model
{
    use AlgoliaEloquentTrait;
    use Translatable;

    public static $autoIndex = true;
    public static $autoDelete = true;

    public $algoliaSettings = [
        'attributesToIndex' => [
            'description',
            'number',
        ],
    ];

    public $translatedAttributes = ['description'];

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
