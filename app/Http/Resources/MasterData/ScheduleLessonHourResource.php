<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleLessonHourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'schedule_day_id' => $this->schedule_day_id,
            'schedule_lesson_hour_name' => $this->schedule_lesson_hour_name,
            'detail_duration' => $this->detail_duration,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'started_duration' => $this->started_duration,
            'ended_duration' => $this->ended_duration,
            'order_direction' => $this->order_direction,
            'is_break_hour' => $this->is_break_hour,
        ];
    }
}
