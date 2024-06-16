<?php

namespace App\Http\Requests\API\MasterData\Lesson;

use App\Http\Requests\API\BaseRequest;

class CreateLessonValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:lessons,name',
            'lesson_category_id' => 'required|exists:lesson_categories,id',
            'acronym' => 'required|unique:lessons,acronym',
        ];
    }
}
