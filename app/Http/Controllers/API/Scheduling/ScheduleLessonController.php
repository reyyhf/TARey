<?php

namespace App\Http\Controllers\API\Scheduling;

use App\Http\Controllers\Controller;
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
}
