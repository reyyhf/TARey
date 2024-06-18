<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Scheduling\ScheduleLesson\CreateScheduleLessonValidation;
use App\Http\Services\Scheduling\ScheduleLessonService;

class ScheduleLessonController extends Controller
{
    protected $service;

    public function __construct(ScheduleLessonService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $scheduleLessons = $this->service->index();

        return $this->serviceResponseHandler($scheduleLessons);
    }

    public function store(CreateScheduleLessonValidation $request)
    {
        $inputData = $request->validated();

        $createClassroom = $this->service->store($inputData);

        return $this->serviceResponseHandler($createClassroom);
    }
}
