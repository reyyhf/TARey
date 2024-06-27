<?php

namespace App\Http\Requests\API\Scheduling\ScheduleLesson;

use App\Http\Requests\API\BaseRequest;

class CreateScheduleLessonItemValidation extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'lesson_id' => 'required|uuid',
      'teacher_id' => 'required|uuid',
      'schedule_lesson_id' => 'required|uuid',
      'schedule_lesson_hour_ids.*' => 'uuid',
    ];
  }
}
