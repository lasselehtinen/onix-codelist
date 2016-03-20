<?php

namespace App\Api\V1\Transformers;

use App\Code;
use League\Fractal;

class CodeTransformer extends Fractal\TransformerAbstract
{
    public function transform(Code $code)
    {
        return [
            'id'            => (int) $code->id,
            'value'         => $code->value,
            'description'   => $code->description,
            'notes'         => $code->notes,
            'issue_number'  => (int) $code->issue_number,
        ];
    }
}
