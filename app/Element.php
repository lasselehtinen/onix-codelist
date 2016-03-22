<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

class Element extends Model
{
    use AlgoliaEloquentTrait;

    public static $autoIndex = true;
    public static $autoDelete = true;

    public $algoliaSettings = [
        'attributesToIndex' => [
            'reference_name',
            'short_name',
            'codelist.description'
        ],
        'disableTypoToleranceOnAttributes' => [
            'short_name'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['reference_name', 'short_name'];

    /**
     * Get the Codelist that owns the Element.
     */
    public function codelist()
    {
        return $this->belongsTo('App\Codelist');
    }

    /**
     * Append codelist number to Algolia record
     * @return void
     */
    public function getAlgoliaRecord()
    {
        $this->number = $this->codelist->number;
        return $this->toArray();
    }
}
