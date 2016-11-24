<?php

namespace App;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use AlgoliaEloquentTrait;
    use Translatable;

    public static $autoIndex = true;
    public static $autoDelete = true;

    public $algoliaSettings = [
        'attributesToIndex' => [
            'value',
            'description',
            'notes',
        ],
    ];

    public $translatedAttributes = ['description', 'notes'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codelist_id', 'value', 'description', 'notes', 'issue_number'];

    /**
     * Get the Codelist that owns the Code.
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
