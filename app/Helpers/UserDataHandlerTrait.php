<?php

namespace App\Helpers;

trait UserDataHandlerTrait
{
    public function getProfileIdAttribute()
    {
        return optional($this->profile)->id;
    }

    public function getIsActiveAttribute()
    {
        return optional($this->profile)->is_active;
    }

    public function getRoleIdAttribute()
    {
        return optional($this->profile->role)->id;
    }

    public function getUserStatusIdAttribute()
    {
        return optional($this->profile->userStatus)->id;
    }

    public function getRoleNameAttribute()
    {
        return optional($this->profile->role)->name;
    }

    public function getNameAttribute()
    {
        return optional($this->profile)->name;
    }

    public function getNuptkAttribute()
    {
        return optional($this->profile)->nuptk;
    }

    public function getGenderNameAttribute()
    {
        $gender = optional($this->profile)->gender;

        return $gender ? 'Wanita' : 'Pria';
    }

    public function getGenderAttribute()
    {
        return optional($this->profile)->gender;
    }

    public function getBirthPlaceAttribute()
    {
        return optional($this->profile)->birth_place;
    }

    public function getUserActivationStatusAttribute()
    {
        $activationStatus = optional($this->profile)->is_active;

        return $activationStatus ? 'Aktif' : 'Tidak Aktif';
    }

    public function getUserStatusNameAttribute()
    {
        return optional($this->profile->userStatus)->name;
    }

    public function getMaximumTeachingLoadAttribute()
    {
        return optional($this->profile)->maximum_teaching_load;
    }

    public function getTeacherLessonsAttribute()
    {
        return optional($this->profile)->teacherLessons->pluck('id');
    }

    public function getTeacherLessonsNameAttribute()
    {
        return optional($this->profile)->teacherLessons->map(fn ($lesson) => [
            'name' => $lesson->name,
        ]);
    }

    public function getTeacherClassroomsAttribute()
    {
        return optional($this->profile)->teacherClassrooms->pluck('id');
    }

    public function getTeacherClassroomsNameAttribute()
    {
        return optional($this->profile)->teacherClassrooms->map(fn ($classroom) => [
            'name' => $classroom->name,
        ]);
    }
}
