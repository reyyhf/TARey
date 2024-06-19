<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Scheduling\ScheduleLesson\CreateScheduleLessonItemValidation;
use App\Http\Requests\API\Scheduling\ScheduleLesson\UpdateScheduleLessonValidation;
use App\Http\Services\Scheduling\ScheduleLessonItemService;

class ScheduleLessonItemController extends Controller
{
    protected ScheduleLessonItemService $service;

    public function __construct(ScheduleLessonItemService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $scheduleLessons = $this->service->index();

        return $this->serviceResponseHandler($scheduleLessons);
    }

    public function store(CreateScheduleLessonItemValidation $request)
    {
        $inputData = $request->validated();

        $scheduleLessonItem = $this->service->store($inputData);

        return $this->serviceResponseHandler($scheduleLessonItem);
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
