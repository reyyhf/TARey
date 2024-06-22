<?php

namespace App\Models\Scheduling;

use App\Models\BaseModel as Base;

class CriteriaConstraint extends Base
{
    protected $table = 'criteria_constraints';

    protected $fillable = [
        'constraint',
        'type',
        'is_dynamic',
        'max_teaching_hours',
        'max_subject_hours'
    ];
}
