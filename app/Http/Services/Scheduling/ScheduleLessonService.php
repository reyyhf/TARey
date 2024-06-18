<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\Scheduling\ScheduleLessonRepository;

class ScheduleLessonService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(ScheduleLessonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $scheduleLessons = $this->repository->index();


        $response = $scheduleLessons;

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }
}
