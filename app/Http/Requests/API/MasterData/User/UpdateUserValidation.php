<?php

namespace App\Http\Requests\API\MasterData\User;

use App\Http\Requests\API\BaseRequest;

class UpdateUserValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'sometimes|required|email|unique:users,email,'.$this->id,
            'name' => 'sometimes|required|unique:profiles,name,'.$this->profile_id,
            'nuptk' => 'sometimes|required|integer|unique:profiles,nuptk,'.$this->profile_id,
            'gender' => 'sometimes|required',
            'birth_place' => 'sometimes|required',
            'is_active' => 'sometimes|required|boolean',
            'role_name' => 'sometimes|required',
            'user_status_id' => 'sometimes|nullable',
            'teacher_lessons' => 'sometimes|nullable|array',
            'teacher_lessons.*' => 'sometimes|required|exists:lessons,id',
            'teacher_classrooms' => 'sometimes|nullable|array',
            'teacher_classrooms.*' => 'sometimes|required|exists:classrooms,id',
            'maximum_teaching_load' => 'sometimes|nullable|integer|min:1',
        ];
    }
}
