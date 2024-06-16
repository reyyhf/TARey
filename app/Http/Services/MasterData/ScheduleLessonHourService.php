<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\ScheduleDayRepository;
use App\Http\Repositories\MasterData\ScheduleLessonHourRepository;
use App\Http\Resources\MasterData\ScheduleLessonHourResource;
use Illuminate\Support\Facades\DB;

class ScheduleLessonHourService
{
    use ApiResponseTrait;

    private $repository;

    private $scheduleDayRepository;

    public function __construct(
        ScheduleLessonHourRepository $repository,
        ScheduleDayRepository $scheduleDayRepository
    ) {
        $this->repository = $repository;
        $this->scheduleDayRepository = $scheduleDayRepository;
    }

    public function index()
    {
        $scheduleDayId = request('schedule_day_id', null);

        $scheduleLessonHours = $this->repository->index($scheduleDayId);

        $scheduleLessonHours = $scheduleLessonHours->each(function ($scheduleLessonHour, $index) {
            $scheduleLessonHour->number = $index + 1;
        });

        $response = ScheduleLessonHourResource::collection($scheduleLessonHours);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        return DB::transaction(function () use ($inputData) {
            foreach ($inputData['durations'] as $duration) {
                $existedHour = $this->repository->findExistedHour(
                    $inputData['schedule_day_id'],
                    $duration['started_at']
                );

                if ($existedHour) {
                    DB::rollBack();
                    throw new ErrorAPIException('Jam Pelajaran Sudah Ada', 400);
                }

                $maximumLessonHour = $this->scheduleDayRepository->find($inputData['schedule_day_id']);

                if ($duration['started_at'] >= $maximumLessonHour->total_hours) {
                    DB::rollBack();
                    throw new ErrorAPIException(
                        'Batas Maksimal Jam Pelajaran Telah Penuh',
                        400
                    );
                }

                $duration['schedule_day_id'] = $inputData['schedule_day_id'];
                $duration['order_direction'] = $duration['started_at'];

                $scheduleLessonHour = $this->repository->store($duration);
            }

            if (! $scheduleLessonHour) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Ditambahkan', 500);
            }

            $result = new ScheduleLessonHourResource($scheduleLessonHour);

            return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
        });
    }

    public function show($id)
    {
        $scheduleLessonHour = $this->repository->find($id);

        $response = new ScheduleLessonHourResource($scheduleLessonHour);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        return DB::transaction(function () use ($id, $inputData) {
            $maximumBreakHours = config('schedule-features.maximum-breaking-time');
            $countMaximumBreakHours = $this->repository->countMaximumBreakHours();

            if ($countMaximumBreakHours >= $maximumBreakHours) {
                DB::rollBack();
                throw new ErrorAPIException(
                    'Jam Istirahat Telah Mencapai Batas Maksimal',
                    400
                );
            }

            $scheduleLessonHour = $this->repository->update($id, $inputData);

            if (! $scheduleLessonHour) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Diubah', 500);
            }

            $result = new ScheduleLessonHourResource($scheduleLessonHour);

            return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
        });
    }

    public function destroy($id)
    {
        $scheduleLessonHour = $this->repository->destroy($id);

        if (! $scheduleLessonHour) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
