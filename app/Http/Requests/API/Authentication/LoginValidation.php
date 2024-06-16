<?php

namespace App\Http\Requests\API\Authentication;

use App\Http\Requests\API\BaseRequest;

class LoginValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
