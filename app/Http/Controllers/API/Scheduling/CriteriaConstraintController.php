<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Scheduling\CriteriaConstraint\CreateCriteriaConstraintValidation;
use App\Http\Services\Scheduling\CriteriaConstraintService;

class CriteriaConstraintController extends Controller
{
    protected CriteriaConstraintService $service;

    public function __construct(CriteriaConstraintService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $criteriaConstraints = $this->service->index();

        return $this->serviceResponseHandler($criteriaConstraints);
    }

    public function store(CreateCriteriaConstraintValidation $request)
    {
        $inputData = $request->validated();

        $createClassroom = $this->service->store($inputData);

        return $this->serviceResponseHandler($createClassroom);
    }
}
