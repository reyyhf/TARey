<?php

namespace App\Models\MasterData;

use App\Models\BaseModel as Base;

class Semester extends Base
{
    protected $table = 'semesters';

    protected $fillable = [
        'started_year',
        'ended_year',
        'is_active',
    ];

    protected $casts = [
        'started_year' => 'integer',
        'ended_year' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scheduleDays()
    {
        return $this->hasMany(ScheduleDay::class);
    }
}
