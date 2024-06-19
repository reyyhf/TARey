<?php

namespace App\Models\Scheduling;

use App\Models\BaseModel as Base;
use App\Models\MasterData\Lesson;
use App\Models\MasterData\ScheduleLessonHour;
use App\Models\Scheduling\ScheduleLesson;
use App\Models\User\Profile;

class ScheduleLessonItem extends Base
{
   protected $table = 'schedule_lesson_items';

   protected $fillable = [
      'lesson_id',
      'teacher_id',
      'schedule_lesson_id',
      'schedule_lesson_hour_id',
   ];

   public function lesson()
   {
      return $this->belongsTo(Lesson::class, 'lesson_id');
   }

   public function teacher()
   {
      return $this->belongsTo(Profile::class, 'teacher_id');
   }

   public function scheduleLesson()
   {
      return $this->belongsTo(ScheduleLesson::class, 'schedule_lesson_id');
   }

   public function scheduleLessonHour()
   {
      return $this->belongsTo(ScheduleLessonHour::class, 'schedule_lesson_hour_id');
   }
}
