<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Scheduling\ScheduleReport\CreateScheduleReportValidation;
use App\Http\Services\Scheduling\ScheduleReportService;

class ScheduleReportController extends Controller
{
    protected ScheduleReportService $service;

    public function __construct(ScheduleReportService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $scheduleReport = $this->service->index();

        return $this->serviceResponseHandler($scheduleReport);
    }

    public function store(CreateScheduleReportValidation $request)
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

    public function dashboard()
    {
        $scheduleReport = $this->service->dashboard();

        return $this->serviceResponseHandler($scheduleReport);
    }


    public function destroy($id)
    {
        $deleteClassroom = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteClassroom);
    }
}
