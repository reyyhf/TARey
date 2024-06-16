<?php

namespace App\Http\Requests\API\MasterData\ScheduleDay;

use App\Http\Requests\API\BaseRequest;

class UpdateScheduleDayValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'total_hours' => 'sometimes|required|numeric|min:1|max:10',
        ];
    }
}
