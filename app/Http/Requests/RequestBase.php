<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RequestBase extends FormRequest
{
    protected function formatErrors(Validator $validator)
    {	
        return collect($validator->errors())->flatMap(function($error,$key)
        {
            return $error;
        })->toArray();
    }
}
