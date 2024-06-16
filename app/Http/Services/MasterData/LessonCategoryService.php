<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\LessonCategoryRepository;
use App\Http\Resources\MasterData\LessonCategoryResource;

class LessonCategoryService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(LessonCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $lessonCategories = $this->repository->index();

        $lessonCategories = $lessonCategories->each(function ($lessonCategory, $index) {
            $lessonCategory->number = $index + 1;
        });

        $response = LessonCategoryResource::collection($lessonCategories);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        $lessonCategory = $this->repository->store($inputData);

        if (! $lessonCategory) {
            throw new ErrorAPIException('Data Gagal Ditambahkan', 500);
        }

        $result = new LessonCategoryResource($lessonCategory);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $lessonCategory = $this->repository->find($id);

        $response = new LessonCategoryResource($lessonCategory);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        $lessonCategory = $this->repository->update($id, $inputData);

        if (! $lessonCategory) {
            throw new ErrorAPIException('Data Gagal Diubah', 500);
        }

        $result = new LessonCategoryResource($lessonCategory);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($id)
    {
        $lessonCategory = $this->repository->destroy($id);

        if (! $lessonCategory) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
