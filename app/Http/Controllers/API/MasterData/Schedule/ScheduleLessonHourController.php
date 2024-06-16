<?php

namespace App\Http\Controllers\API\MasterData\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\ScheduleLessonHour\CreateScheduleLessonHourValidation;
use App\Http\Requests\API\MasterData\ScheduleLessonHour\UpdateScheduleLessonHourValidation;
use App\Http\Services\MasterData\ScheduleLessonHourService;

class ScheduleLessonHourController extends Controller
{
    protected $service;

    public function __construct(ScheduleLessonHourService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $scheduleDays = $this->service->index();

        return $this->serviceResponseHandler($scheduleDays);
    }

    public function store(CreateScheduleLessonHourValidation $request)
    {
        $inputData = $request->validated();

        $updateScheduleDay = $this->service->store($inputData);

        return $this->serviceResponseHandler($updateScheduleDay);
    }

    public function show($id)
    {
        $scheduleDay = $this->service->show($id);

        return $this->serviceResponseHandler($scheduleDay);
    }

    public function update(UpdateScheduleLessonHourValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateScheduleDay = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateScheduleDay);
    }

    public function destroy($id)
    {
        $destroyScheduleDay = $this->service->destroy($id);

        return $this->serviceResponseHandler($destroyScheduleDay);
    }
}
