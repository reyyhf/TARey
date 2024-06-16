<?php

namespace App\Http\Controllers\API\MasterData\Lesson;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\LessonCategory\CreateLessonCategoryValidation;
use App\Http\Requests\API\MasterData\LessonCategory\UpdateLessonCategoryValidation;
use App\Http\Services\MasterData\LessonCategoryService;

class LessonCategoryController extends Controller
{
    protected $service;

    public function __construct(LessonCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $lessonCategories = $this->service->index();

        return $this->serviceResponseHandler($lessonCategories);
    }

    public function store(CreateLessonCategoryValidation $request)
    {
        $inputData = $request->validated();

        $createLessonCategory = $this->service->store($inputData);

        return $this->serviceResponseHandler($createLessonCategory);
    }

    public function show($id)
    {
        $lessonCategory = $this->service->show($id);

        return $this->serviceResponseHandler($lessonCategory);
    }

    public function update(UpdateLessonCategoryValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateLessonCategory = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateLessonCategory);
    }

    public function destroy($id)
    {
        $deleteLessonCategory = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteLessonCategory);
    }
}
