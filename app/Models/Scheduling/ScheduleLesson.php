<?php

namespace App\Models\Scheduling;

use App\Models\BaseModel as Base;
use App\Models\MasterData\Classroom;
use App\Models\MasterData\CurriculumLesson;
use App\Models\MasterData\Semester;

class ScheduleLesson extends Base
{
   protected $table = 'schedule_lessons';

   protected $fillable = [
      'semester_id',
      'classroom_id',
      'curriculum_type',
      'status'
   ];


   public function semester()
   {
      return $this->belongsTo(Semester::class, 'semester_id');
   }

   public function classroom()
   {
      return $this->belongsTo(Classroom::class, 'classroom_id');
   }

   public function scheduleLessonItems()
   {
      return $this->hasMany(ScheduleLessonItem::class, 'schedule_lesson_id', 'id');
   }
}
