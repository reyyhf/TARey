<?php

namespace App\Http\Requests\API\Scheduling\ScheduleReport;

use App\Http\Requests\API\BaseRequest;

class CreateScheduleReportValidation extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'title' => 'required',
      'data' => 'required',
    ];
  }
}
