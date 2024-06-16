<?php

namespace App\Http\Requests\API\MasterData\ScheduleLessonHour;

use App\Http\Requests\API\BaseRequest;

class CreateScheduleLessonHourValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'schedule_day_id' => 'required|exists:schedule_days,id',
            'durations' => 'required|array',
            'durations.*.started_at' => 'required|numeric',
            'durations.*.ended_at' => 'required|numeric|gt:durations.*.started_at',
            'durations.*.started_duration' => 'required',
            'durations.*.ended_duration' => 'required',
        ];
    }
}
