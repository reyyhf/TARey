<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\ClassroomRepository;
use App\Http\Resources\MasterData\ClassroomResource;

class ClassroomService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(ClassroomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $classrooms = $this->repository->index();

        $classrooms = $classrooms->each(function ($classroom, $index) {
            $classroom->number = $index + 1;
        });

        $response = ClassroomResource::collection($classrooms);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function getClassroomLabel()
    {
        $labels = $this->repository->getClassroomLabel();

        $labels = $labels->map(function ($label) {
            return [
                'id' => $label->first()->label,
                'label' => $label->first()->label,
            ];
        });

        $response = collect($labels)->values();

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        $label = explode(' ', $inputData['name']);
        $inputData['label'] = $label[0].' '.$label[1];

        $classroom = $this->repository->store($inputData);

        if (! $classroom) {
            throw new ErrorAPIException('Data Gagal Ditambahkan', 500);
        }

        $result = new ClassroomResource($classroom);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $classroom = $this->repository->find($id);

        $response = new ClassroomResource($classroom);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        $label = explode(' ', $inputData['name']);
        $inputData['label'] = $label[0].' '.$label[1];

        $classroom = $this->repository->update($id, $inputData);

        if (! $classroom) {
            throw new ErrorAPIException('Data Gagal Diubah', 500);
        }

        $result = new ClassroomResource($classroom);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($id)
    {
        $classroom = $this->repository->destroy($id);

        if (! $classroom) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
