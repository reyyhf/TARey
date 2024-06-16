<?php

namespace App\Http\Controllers\API\MasterData\Lesson;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\Lesson\CreateLessonValidation;
use App\Http\Requests\API\MasterData\Lesson\UpdateLessonValidation;
use App\Http\Services\MasterData\LessonService;

class LessonController extends Controller
{
    protected $service;

    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $lessons = $this->service->index();

        return $this->serviceResponseHandler($lessons);
    }

    public function store(CreateLessonValidation $request)
    {
        $inputData = $request->validated();

        $createLesson = $this->service->store($inputData);

        return $this->serviceResponseHandler($createLesson);
    }

    public function show($id)
    {
        $lesson = $this->service->show($id);

        return $this->serviceResponseHandler($lesson);
    }

    public function update(UpdateLessonValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateLesson = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateLesson);
    }

    public function destroy($id)
    {
        $deleteLesson = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteLesson);
    }
}
