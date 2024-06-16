<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\SemesterRepository;
use App\Http\Resources\MasterData\SemesterResource;
use Illuminate\Support\Facades\DB;

class SemesterService
{
    use ApiResponseTrait;

    private $repository;

    private $scheduleDayService;

    public function __construct(
        SemesterRepository $repository,
        ScheduleDayService $scheduleDayService
    ) {
        $this->repository = $repository;
        $this->scheduleDayService = $scheduleDayService;
    }

    public function index()
    {
        $semesters = $this->repository->index();

        $semesters = $semesters->each(function ($semester, $index) {
            $semester->number = $index + 1;
        });

        $response = SemesterResource::collection($semesters);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        return DB::transaction(function () use ($inputData) {
            $checkActiveSemester = $this->checkActiveSemester();

            if ($inputData['is_active'] == true && $checkActiveSemester) {
                DB::rollBack();
                throw new ErrorAPIException('Masih ada Tahun Ajaran Yang Aktif', 400);
            }

            $semester = $this->repository->store($inputData);

            if (! $semester) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Ditambahkan', 400);
            }

            $scheduleDays = config('schedule-features.schedule-days');
            foreach ($scheduleDays as $scheduleDay) {
                $scheduleDay['semester_id'] = $semester->id;
                $storeScheduleDay = $this->scheduleDayService->store($scheduleDay);

                if (! $storeScheduleDay) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Ditambahkan', 400);
                }
            }

            $result = new SemesterResource($semester);

            return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
        });
    }

    public function show($id)
    {
        $semester = $this->repository->find($id);

        $response = new SemesterResource($semester);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    protected function checkActiveSemester()
    {
        return $this->repository->findColumn('is_active', true);
    }

    public function findActiveSemester()
    {
        $activeSemester = $this->checkActiveSemester();

        return new SemesterResource($activeSemester);
    }

    public function update($id, $inputData)
    {
        $checkActiveSemester = $this->checkActiveSemester();

        if ($inputData['is_active'] == true && $checkActiveSemester) {
            throw new ErrorAPIException('Masih ada Tahun Ajaran Yang Aktif', 400);
        }

        $semester = $this->repository->update($id, $inputData);

        if (! $semester) {
            throw new ErrorAPIException('Data Gagal Diubah', 400);
        }

        $result = new SemesterResource($semester);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $checkSemester = $this->repository->find($id);

            if ($checkSemester->is_active) {
                DB::rollBack();
                throw new ErrorAPIException('Tidak Bisa Menghapus Tahun Ajaran Yang Aktif', 400);
            }

            $activeScheduleDays = $this->scheduleDayService->getData('semester_id', $id);

            $destroyScheduleDays = $activeScheduleDays->each(function ($scheduleDay) {
                $this->scheduleDayService->destroy($scheduleDay->id);
            });

            if (! $destroyScheduleDays) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Dihapus', 500);
            }

            $semester = $this->repository->destroy($id);

            if (! $semester) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Dihapus', 500);
            }

            return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
        });
    }
}
