<?php

namespace App\Http\Requests\API\Scheduling\CriteriaConstraint;

use App\Http\Requests\API\BaseRequest;

class CreateCriteriaConstraintValidation extends BaseRequest
{

    public function rules()
    {
        return
            [
                "max_teaching_hours" => 'required|integer',
                "max_subject_hours" => 'required|integer'
            ];
    }
}
