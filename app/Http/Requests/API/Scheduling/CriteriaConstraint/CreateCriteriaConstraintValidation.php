<?php

namespace App\Http\Requests\API\Scheduling\ScheduleLesson;

use App\Http\Requests\API\BaseRequest;

class CreateCriteriaConstraintValidation extends BaseRequest
{

    public function rules()
    {
        return
            [
                "constraint" => 'nullable|string',
                "type" => 'required|in:hard,soft',
                "is_dynamic" => 'required|boolean',
                "max_teaching_hours" => 'nullable|number',
                "max_subject_hours" => 'nullable|number'
            ];
    }
}
