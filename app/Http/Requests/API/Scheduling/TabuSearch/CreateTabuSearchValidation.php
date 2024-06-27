<?php

namespace App\Http\Requests\API\Scheduling\TabuSearch;

use App\Http\Requests\API\BaseRequest;

class CreateTabuSearchValidation extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tabu_size' => 'numeric|min:1',
            'max_iteration' => 'numeric|min:0',
        ];
    }
}
