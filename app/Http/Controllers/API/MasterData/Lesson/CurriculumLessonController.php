<?php

namespace App\Http\Controllers\API\MasterData\Lesson;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\CurriculumLesson\CreateCurriculumLessonValidation;
use App\Http\Requests\API\MasterData\CurriculumLesson\UpdateCurriculumLessonValidation;
use App\Http\Services\MasterData\CurriculumLessonService;

class CurriculumLessonController extends Controller
{
    protected $service;

    public function __construct(CurriculumLessonService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $curriculumLessons = $this->service->index();

        return $this->serviceResponseHandler($curriculumLessons, 'Data Berhasil Ditampilkan');
    }

    public function store(CreateCurriculumLessonValidation $request)
    {
        $inputData = $request->validated();

        $createCurriculumLesson = $this->service->store($inputData);

        return $this->serviceResponseHandler($createCurriculumLesson, 'Data Berhasil Ditambahkan', 201);
    }

    public function show($id)
    {
        $curriculumLesson = $this->service->show($id);

        return $this->serviceResponseHandler($curriculumLesson, 'Spesifik Data Berhasil Ditampilkan');
    }

    public function update(UpdateCurriculumLessonValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateCurriculumLesson = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateCurriculumLesson, 'Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $deleteCurriculumLesson = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteCurriculumLesson, 'Data Berhasil Dihapus');
    }
}
