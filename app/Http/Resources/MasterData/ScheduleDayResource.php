<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleDayResource extends JsonResource
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
            'name' => $this->name,
            'semester_data' => $this->semester_data,
            'semester_id' => $this->semester_id,
            'total_hours' => $this->total_hours,
            'schedule_lesson_hours' => $this->schedule_lesson_hours
        ];
    }
}
