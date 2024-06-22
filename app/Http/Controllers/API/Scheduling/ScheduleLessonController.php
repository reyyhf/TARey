<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Scheduling\ScheduleLesson\CreateScheduleLessonValidation;
use App\Http\Requests\API\Scheduling\ScheduleLesson\UpdateScheduleLessonValidation;
use App\Http\Services\Scheduling\ScheduleLessonService;

class ScheduleLessonController extends Controller
{
    protected ScheduleLessonService $service;

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

    public function show($id)
    {
        $semester = $this->service->show($id);

        return $this->serviceResponseHandler($semester);
    }

    public function update(UpdateScheduleLessonValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateClassroom = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateClassroom);
    }

    public function destroy($id)
    {
        $deleteClassroom = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteClassroom);
    }
}
