<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Scheduling\TabuSearch\CreateTabuSearchValidation;
use App\Http\Services\Scheduling\TabuSearchService;

class TabuSearchController extends Controller
{
    protected TabuSearchService $service;

    public function __construct(TabuSearchService $service)
    {
        $this->service = $service;
    }

    public function search(CreateTabuSearchValidation $request)
    {
        set_time_limit(3600);

        $inputData = $request->validated();

        $createClassroom = $this->service->search($inputData);

        return $this->serviceResponseHandler($createClassroom);
    }
}
