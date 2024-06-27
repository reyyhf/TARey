<?php

namespace App\Http\Services\MasterData;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\ScheduleDayRepository;
use App\Http\Repositories\MasterData\ScheduleLessonHourRepository;
use App\Http\Resources\MasterData\ScheduleDayResource;
use Illuminate\Support\Facades\DB;

class ScheduleDayService
{
    use ApiResponseTrait;

    private $repository;

    private $scheduleLessonHourRepository;

    public function __construct(
        ScheduleDayRepository $repository,
        ScheduleLessonHourRepository $scheduleLessonHourRepository
    ) {
        $this->repository = $repository;
        $this->scheduleLessonHourRepository = $scheduleLessonHourRepository;
    }

    public function index()
    {
        $scheduleDays = $this->repository->index();

        $scheduleDays = $scheduleDays->each(function ($scheduleDay, $index) {
            $scheduleDay->number = $index + 1;
        });

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $scheduleDays);
    }

    public function getData($columns, $params)
    {
        return $this->repository->getColumn($columns, $params);
    }

    public function store($inputData)
    {
        $scheduleDay = $this->repository->store($inputData);

        if (!$scheduleDay) {
            throw new ErrorAPIException('Data Gagal Ditambahkan', 500);
        }

        $result = new ScheduleDayResource($scheduleDay);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $scheduleDay = $this->repository->find($id);

        $response = new ScheduleDayResource($scheduleDay);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        return DB::transaction(function () use ($id, $inputData) {

            $findTotalHour = $this->repository->find($id);
            $existedTotalHours = $findTotalHour->total_hours;

            $data = [];

            if ($inputData['total_hours'] >= $existedTotalHours) {
                for ($i = $inputData['total_hours'] - 1; $i >= $existedTotalHours; $i--) {
                    $data[] = [
                        'schedule_day_id' => $id,
                        'started_at' => $i,
                        'ended_at' => $i + 1,
                        'started_duration' => '00:00',
                        'ended_duration' => '00:00',
                        'order_direction' => $i,
                        'is_break_hour' => 0,
                    ];
                }

                foreach ($data as $item) {
                    $storeScheduleLessonHour = $this->scheduleLessonHourRepository->checkUpdateOrCreate(
                        [
                            'schedule_day_id' => $id,
                            'started_at' => $item['started_at'],
                            'ended_at' => $item['ended_at'],
                            'order_direction' => $item['order_direction'],
                        ],
                        $item
                    );

                    if (!$storeScheduleLessonHour) {
                        DB::rollBack();
                        throw new ErrorAPIException('Gagal Menyimpan Data', 500);
                    }
                }
            } elseif ($inputData['total_hours'] <= $existedTotalHours) {
                for ($i = $inputData['total_hours']; $i <= $existedTotalHours; $i++) {
                    $data[] = $i;
                }

                $scheduleLessonHours = $this->scheduleLessonHourRepository->getByOrderDirection($id, $data);

                if ($scheduleLessonHours) {
                    $destroyScheduleLessonHour = $scheduleLessonHours->delete();

                    if (!$destroyScheduleLessonHour) {
                        DB::rollBack();
                        throw new ErrorAPIException('Gagal Menghapus Data', 500);
                    }
                }
            }

            $scheduleDay = $this->repository->update($id, $inputData);

            if (!$scheduleDay) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Diubah', 500);
            }

            $result = new ScheduleDayResource($scheduleDay);

            return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
        });
    }

    public function destroy($id)
    {
        $scheduleDay = $this->repository->destroy($id);

        if (!$scheduleDay) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
