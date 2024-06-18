<?php

namespace App\Http\Requests\API\Scheduling\ScheduleLesson;

use App\Http\Requests\API\BaseRequest;

class CreateScheduleLessonValidation extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'semester_id' => 'required|uuid',
      'classroom_id' => 'required|uuid',
      'curriculum_type' => 'required|string'
    ];
  }
}
