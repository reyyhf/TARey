<?php

namespace App\Http\Requests\API;

use App\Helpers\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $validationMessage = $validator->errors()->first();
        $response = $this->resultResponse('error', $validationMessage, 400);

        throw new ValidationException($validator, $response);
    }
}
