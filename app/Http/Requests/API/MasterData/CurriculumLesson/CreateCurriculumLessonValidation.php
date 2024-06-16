<?php

namespace App\Http\Requests\API\MasterData\CurriculumLesson;

use App\Http\Requests\API\BaseRequest;

class CreateCurriculumLessonValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lesson_id' => 'required|exists:lessons,id',
            'curricular' => 'required|array',
            'curricular.*.classroom_label' => 'required|exists:classrooms,label',
            'curricular.*.maximum_hours_per_week' => 'required|integer',
        ];
    }
}
