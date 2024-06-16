<?php

namespace App\Http\Controllers\API\MasterData\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\ScheduleDay\UpdateScheduleDayValidation;
use App\Http\Services\MasterData\ScheduleDayService;

class ScheduleDayController extends Controller
{
    protected $service;

    public function __construct(ScheduleDayService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $scheduleDays = $this->service->index();

        return $this->serviceResponseHandler($scheduleDays);
    }

    public function show($id)
    {
        $scheduleDay = $this->service->show($id);

        return $this->serviceResponseHandler($scheduleDay);
    }

    public function update(UpdateScheduleDayValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateScheduleDay = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateScheduleDay);
    }
}
