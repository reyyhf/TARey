<?php

namespace App\Http\Requests\API\MasterData\Classroom;

use App\Http\Requests\API\BaseRequest;

class CreateClassroomValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'unique:classrooms,name',
                'regex:/^(X|XI|XII) (IPA|IPS) [1-9]\d*$/'
            ],
            'majority' => 'required',
            'quota' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.regex' => 'The name must follow the pattern "X IPA 1", "X IPA 2", "XI IPA 1", "XI IPA 2", "XII IPA 1", "XII IPA 2", and so on.'
        ];
    }
}
