<?php

namespace App\Http\Requests\API\MasterData\ScheduleLessonHour;

use App\Http\Requests\API\BaseRequest;

class UpdateScheduleLessonHourValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'schedule_day_id' => 'sometimes|exists:schedule_days,id',
            'started_at' => 'sometimes|numeric',
            'ended_at' => 'sometimes|numeric|after:duration.*.started_at',
            'started_duration' => 'sometimes',
            'ended_duration' => 'sometimes',
            'is_break_hour' => 'sometimes|boolean',
        ];
    }
}
