<?php

namespace App\Api\V1\Transformers;

use App\Codelist;
use League\Fractal;

class CodelistTransformer extends Fractal\TransformerAbstract
{
    public function transform(Codelist $codelist)
    {
        return [
            'id'            => (int) $codelist->id,
            'number'        => (int) $codelist->number,
            'description'   => $codelist->description,
            'issue_number'  => (int) $codelist->issue_number,
        ];
    }
}
