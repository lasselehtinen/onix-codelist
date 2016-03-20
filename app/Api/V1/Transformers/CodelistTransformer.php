<?php

namespace App\Api\V1\Transformers;

use App\Codelist;
use League\Fractal;

class CodelistTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'codes'
    ];

    public function transform(Codelist $codelist)
    {
        return [
            'id'            => (int) $codelist->id,
            'number'        => (int) $codelist->number,
            'description'   => $codelist->description,
            'issue_number'  => (int) $codelist->issue_number,
        ];
    }

    /**
     * Include Code
     *
     * @return League\Fractal\ItemResource
     */
    public function includeCodes(Codelist $codelist)
    {
        $codes = $codelist->codes;

        return $this->collection($codes, new CodeTransformer);
    }
}
