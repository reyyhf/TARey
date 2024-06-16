<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'name' => $this->name,
            'nuptk' => $this->nuptk,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'user_status_id' => $this->user_status_id,
            'gender ' => $this->gender,
            'birth_place' => $this->birth_place,
            'is_active' => $this->is_active,
        ];
    }
}
