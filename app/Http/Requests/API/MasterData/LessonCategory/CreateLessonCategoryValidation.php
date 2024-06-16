<?php

namespace App\Http\Requests\API\MasterData\LessonCategory;

use App\Http\Requests\API\BaseRequest;

class CreateLessonCategoryValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:lesson_categories,name',
        ];
    }
}
