<?php

namespace App\Http\Requests\API\MasterData\Classroom;

use App\Http\Requests\API\BaseRequest;

class UpdateClassroomValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:classrooms,name,'.$this->id,
            'majority' => 'required',
            'quota' => 'required|integer',
        ];
    }
}
