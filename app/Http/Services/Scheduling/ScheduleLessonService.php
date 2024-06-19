<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\SemesterRepository;
use App\Http\Repositories\Scheduling\ScheduleLessonRepository;
use Illuminate\Support\Facades\Log;

class ScheduleLessonService
{
    use ApiResponseTrait;

    private ScheduleLessonRepository $repository;
    private SemesterRepository $semesterRepository;

    public function __construct(ScheduleLessonRepository $repository, SemesterRepository $semesterRepository)
    {
        $this->repository = $repository;
        $this->semesterRepository = $semesterRepository;
    }

    public function index()
    {
        $scheduleLessons = $this->repository->index();

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $scheduleLessons);
    }

    public function store($inputData)
    {
        $semester = $this->semesterRepository->findActiveSemester();
        if (!$semester) {
            throw new ErrorAPIException('Semester aktif tidak ditemukan', 400);
        }

        $inputData['semester_id'] = $semester->id;

        $scheduleLesson = $this->repository->store($inputData);

        return $this->resultResponse('success', 'Data berhasil ditambahnkan', 201, $scheduleLesson);
    }


    public function show($id)
    {
        $scheduleLesson = $this->repository->findScheduleLesson($id);

        return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $scheduleLesson);
    }

    public function update($id, $inputData)
    {
        $semester = $this->semesterRepository->findActiveSemester();
        if (!$semester) {
            throw new ErrorAPIException('Semester aktif tidak ditemukan', 400);
        }

        $inputData['semester_id'] = $semester->id;

        $scheduleLesson = $this->repository->update($id, $inputData);
        if (!$scheduleLesson) {
            throw new ErrorAPIException('Jadwal gagal diubah', 500);
        }


        return $this->resultResponse('success', 'Data berhasil ditambahnkan', 201, $scheduleLesson);
    }

    public function destroy($id)
    {
        $classroom = $this->repository->destroy($id);

        if (!$classroom) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
