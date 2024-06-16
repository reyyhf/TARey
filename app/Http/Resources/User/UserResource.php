<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'number' => $this->number,
            'email' => $this->email,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'role_name' => $this->role_name,
            'nuptk' => $this->nuptk,
            'gender' => $this->gender,
            'gender_name' => $this->gender_name,
            'birth_place' => $this->birth_place,
            'user_activation_status' => $this->user_activation_status,
            'user_status_name' => $this->user_status_name,
            'profile_id' => $this->profile_id,
            'role_id' => $this->role_id,
            'user_status_id' => $this->user_status_id,
            'maximum_teaching_load' => $this->maximum_teaching_load,
        ];

        $checkTeacherLessons = isset($this->profile->teacherLessons) && count($this->profile->teacherLessons) > 0;

        if ($checkTeacherLessons) {
            $result = array_merge($result, [
                'teacher_lessons' => $this->teacher_lessons,
                'teacher_lessons_name' => $this->teacher_lessons_name,
            ]);
        }

        $checkTeacherClassrooms = isset($this->profile->teacherClassrooms) && count($this->profile->teacherClassrooms) > 0;

        if ($checkTeacherClassrooms) {
            $result = array_merge($result, [
                'teacher_classrooms' => $this->teacher_classrooms,
                'teacher_classrooms_name' => $this->teacher_classrooms_name,
            ]);
        }

        return $result;
    }
}
