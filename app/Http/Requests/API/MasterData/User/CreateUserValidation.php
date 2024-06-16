<?php

namespace App\Http\Requests\API\MasterData\User;

use App\Http\Requests\API\BaseRequest;

class CreateUserValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|unique:profiles,name',
            'nuptk' => 'required|integer|unique:profiles,nuptk',
            'password' => 'sometimes|nullable',
            'gender' => 'required|boolean',
            'birth_place' => 'required',
            'is_active' => 'required|boolean',
            'role_name' => 'required',
            'user_status_id' => 'sometimes|nullable',
            'teacher_lessons' => 'sometimes|nullable|array',
            'teacher_lessons.*' => 'sometimes|required|exists:lessons,id',
            'teacher_classrooms' => 'sometimes|nullable|array',
            'teacher_classrooms.*' => 'sometimes|required|exists:classrooms,id',
            'maximum_teaching_load' => 'sometimes|nullable|integer|min:1',
        ];
    }
}
