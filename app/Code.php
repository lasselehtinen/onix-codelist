<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

class Code extends Model
{
    use AlgoliaEloquentTrait;

    public static $autoIndex = true;
    public static $autoDelete = true;

    public $algoliaSettings = [
        'attributesToIndex' => [
            'value',
            'description',
            'notes',
        ],
    ];

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
     * Creates or updates the Codelist Code and attaches it to the codelist through the attribute query
     * @param  \stdClass $code
     * @param  Codelist  $codelist
     * @return Code
     */
    public static function updateAndAttach(\stdClass $code, Codelist $codelist)
    {
        $code = Code::updateOrCreate(['codelist_id' => $codelist->id, 'value' => $code->CodeValue], [
            'description'   => $code->CodeDescription,
            'notes'         => isset($code->CodeNotes) ? $code->CodeNotes : null,
            'issue_number'  => $code->IssueNumber,
        ]);

        return $code;
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
