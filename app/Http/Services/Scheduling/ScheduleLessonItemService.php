<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\Scheduling\ScheduleLessonItemRepository;
use App\Http\Requests\API\Scheduling\ScheduleLesson\CreateScheduleLessonItemValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleLessonItemService
{
  use ApiResponseTrait;

  private ScheduleLessonItemRepository $repository;

  public function __construct(ScheduleLessonItemRepository $repository)
  {
    $this->repository = $repository;
  }

  public function index($scheduleLessonId)
  {
    Log::info($scheduleLessonId);
    $scheduleLessonItems = $this->repository->findScheduleLessonItems($scheduleLessonId);

    return $this->resultResponse('success', 'Data berhasil didapatkan', 200, $scheduleLessonItems);
  }

  public function show($id)
  {
    $scheduleLesson = $this->repository->findScheduleLessonItem($id);

    return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $scheduleLesson);
  }

  public function store($inputData)
  {
    $scheduleLessonItems = [];
    DB::transaction(function () use (&$inputData, &$scheduleLessonItems) {


      foreach ($inputData['schedule_lesson_hour_ids'] as $scheduleLessonHourId) {

        if ($this->repository->isConflict($inputData['schedule_lesson_id'], $scheduleLessonHourId)) {
          DB::rollBack();
          throw new ErrorAPIException('Terdapat jadwal yang konflik', 400);
        }

        $scheduleLessonItems[] = $this->repository->store([
          'lesson_id' => $inputData['lesson_id'],
          'teacher_id' => $inputData['teacher_id'],
          'schedule_lesson_id' => $inputData['schedule_lesson_id'],
          'schedule_lesson_hour_id' => $scheduleLessonHourId,
        ]);
      }
    });

    return $this->resultResponse('success', 'Data berhasil ditambahnkan', 201, $scheduleLessonItems);
  }

  public function update($id, $inputData)
  {
    if ($this->repository->isConflict($inputData['schedule_lesson_id'], $inputData['schedule_lesson_hour_id'])) {
      throw new ErrorAPIException('Terdapat jadwal yang konflik', 400);
    }

    $scheduleLesson = $this->repository->update($id, $inputData);
    if (!$scheduleLesson) {
      throw new ErrorAPIException('Gagal diubah', 500);
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
