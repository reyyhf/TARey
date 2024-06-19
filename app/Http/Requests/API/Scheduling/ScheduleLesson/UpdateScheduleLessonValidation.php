<?php

namespace App\Http\Requests\API\Scheduling\ScheduleLesson;

use App\Http\Requests\API\BaseRequest;

class UpdateScheduleLessonValidation extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'classroom_id' => 'required|uuid',
      'curriculum_type' => [
        'required',
        'regex:/^(X|XI|XII) (IPA|IPS)/'
      ]
    ];
  }
}
