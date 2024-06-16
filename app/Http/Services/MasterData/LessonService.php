<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\LessonRepository;
use App\Http\Resources\MasterData\LessonResource;

class LessonService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(LessonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $lessons = $this->repository->index();

        $lessons = $lessons->each(function ($lesson, $index) {
            $lesson->number = $index + 1;
        });

        $response = LessonResource::collection($lessons);

        return $this->resultResponse('success', 'Data Berhasil Ditemukan', 200, $response);
    }

    public function store($inputData)
    {
        $lesson = $this->repository->store($inputData);

        if (! $lesson) {
            return $this->resultResponse('error', 'Data Gagal Ditambahkan', 500);
        }

        $result = new LessonResource($lesson);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $lesson = $this->repository->find($id);

        $response = new LessonResource($lesson);

        return $this->resultResponse('success', 'Data Berhasil Ditemukan', 200, $response);
    }

    public function update($id, $inputData)
    {
        $lesson = $this->repository->update($id, $inputData);

        if (! $lesson) {
            throw new ErrorAPIException('Data Gagal Diubah', 500);
        }

        $result = new LessonResource($lesson);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($id)
    {
        $lesson = $this->repository->destroy($id);

        if (! $lesson) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
