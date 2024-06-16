<?php

namespace App\Http\Requests\API\MasterData\CurriculumLesson;

use App\Http\Requests\API\BaseRequest;

class UpdateCurriculumLessonValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lesson_id' => 'sometimes|required|exists:lessons,id',
            'curricular' => 'sometimes|required|array',
            'curricular.*.id' => 'sometimes|required|exists:curriculum_lessons,id',
            'curricular.*.classroom_label' => 'sometimes|required|exists:classrooms,label',
            'curricular.*.maximum_hours_per_week' => 'sometimes|required|integer',
            'removed_data' => 'sometimes|nullable|array',
        ];
    }
}
