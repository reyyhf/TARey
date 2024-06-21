<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\Scheduling\CriteriaConstraintRepository;

class CriteriaConstraintService
{
    use ApiResponseTrait;

    private CriteriaConstraintRepository $repository;


    public function __construct(CriteriaConstraintRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $criteriaConstraints = $this->repository->index();

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $criteriaConstraints);
    }

    public function store($inputData)
    {
        $scheduleLesson = $this->repository->store($inputData);

        return $this->resultResponse('success', 'Data berhasil ditambahnkan', 201, $scheduleLesson);
    }

}
