<?php

namespace App\Models\MasterData;

use App\Models\BaseModel as Base;

class Classroom extends Base
{
    protected $table = 'classrooms';

    protected $fillable = [
        'name',
        'majority',
        'quota',
        'label',
    ];

    protected $casts = [
        'quota' => 'integer',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_classrooms', 'classroom_label', 'lesson_id');
    }

    public function scopeGetClassroomLabel($query)
    {
        return $query
            ->orderBy('label', 'asc')
            ->get()
            ->groupBy('label');
    }
}
