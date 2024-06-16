<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class CurriculumLessonResource extends JsonResource
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
            'number' => $this->number,
            // 'lessons' => $this->lessons->pluck('name'),
            // 'classrooms' => $this->lessons->pluck('classrooms')->flatten(),
            'maximum_hours_per_week' => $this->maximum_hours_per_week,
        ];
    }
}
