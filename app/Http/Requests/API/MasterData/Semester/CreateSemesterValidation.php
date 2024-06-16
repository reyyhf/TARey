<?php

namespace App\Http\Requests\API\MasterData\Semester;

use App\Http\Requests\API\BaseRequest;

class CreateSemesterValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'started_year' => 'sometimes|integer|required|min:2024|unique:semesters,started_year',
            'ended_year' => 'sometimes|integer|required|gt:started_year|unique:semesters,ended_year',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
