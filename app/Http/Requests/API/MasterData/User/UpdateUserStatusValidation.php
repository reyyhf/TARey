<?php

namespace App\Http\Requests\API\MasterData\User;

use App\Http\Requests\API\BaseRequest;

class UpdateUserStatusValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:user_statuses,name,'.$this->id,
            'minimum_teach_load_hour' => 'required|numeric',
        ];
    }
}
