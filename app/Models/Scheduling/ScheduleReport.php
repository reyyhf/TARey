<?php

namespace App\Models\Scheduling;

use App\Models\BaseModel as Base;

class ScheduleReport extends Base
{
   protected $fillable = [
      'title',
      'data',
      'reported_by'
   ];
}
