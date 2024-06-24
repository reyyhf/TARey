<?php

namespace App\Models\MasterData;

use App\Models\BaseModel as Base;

class ScheduleDay extends Base
{
    protected $table = 'schedule_days';

    protected $fillable = [
        'semester_id',
        'name',
        'order_direction',
        'total_hours',
    ];

    protected $casts = [
        'order_direction' => 'integer',
        'total_hours' => 'integer',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function scheduleLessonHours()
    {
        return $this->hasMany(ScheduleLessonHour::class);
    }

    public function getSemesterDataAttribute()
    {
        $startedYear = optional($this->semester)->started_year;
        $endedYear = optional($this->semester)->ended_year;

        return $startedYear . ' / ' . $endedYear;
    }
}
