<?php

namespace App\Models\MasterData;

use App\Models\BaseModel as Base;

class Lesson extends Base
{
    protected $table = 'lessons';

    protected $fillable = [
        'lesson_category_id',
        'name',
        'acronym',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'curriculum_lessons', 'lesson_id', 'classroom_label')
            ->as('curriculum')
            ->withTimestamps()
            ->withPivot('maximum_hours_per_week', 'semester_id');
        // ->using(CurriculumLesson::class);
    }

    public function lessonCategory()
    {
        return $this->belongsTo(LessonCategory::class, 'lesson_category_id');
    }

    public function getLessonCategoryNameAttribute()
    {
        return optional($this->lessonCategory)->name;
    }
}
