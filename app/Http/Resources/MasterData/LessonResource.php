<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'number' => $this->number,
            'name' => $this->name,
            'acronym' => $this->acronym,
            'lesson_category_id' => $this->lesson_category_id,
            'lesson_category_name' => $this->lesson_category_name,
        ];

        if (isset($this->classrooms) && count($this->classrooms) > 0) {
            $mappedCurriculum = $this->classrooms->map(function ($classroom) {
                return [
                    'id' => $classroom->id,
                    'classroom_name' => $classroom->name,
                    'maximum_hours_per_week' => $classroom->curriculum->maximum_hours_per_week,
                ];
            });

            $result = array_merge($result, [
                'curriculum' => $mappedCurriculum,
                'classroom_ids' => $this->classrooms->pluck('id')->toArray(),
            ]);
        }

        return $result;
    }
}
