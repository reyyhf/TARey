<?php

namespace App\Models\User;

use App\Models\BaseModel as Base;
use App\Models\MasterData\Classroom;
use App\Models\MasterData\Lesson;
use App\Models\User;

class Profile extends Base
{
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'role_id',
        'user_status_id',
        'nuptk',
        'name',
        'gender',
        'birth_place',
        'is_active',
        'maximum_teaching_load',
    ];

    protected $casts = [
        'gender' => 'boolean',
        'is_active' => 'boolean',
        'maximum_teaching_load' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function userStatus()
    {
        return $this->belongsTo(UserStatus::class, 'user_status_id');
    }

    public function teacherLessons()
    {
        return $this->belongsToMany(Lesson::class, 'teacher_lessons', 'profile_id', 'lesson_id')
            ->withPivot('classroom_id');
    }

    public function teacherClassrooms()
    {
        return $this->belongsToMany(Classroom::class, 'teacher_lessons', 'profile_id', 'classroom_id');
    }
}
