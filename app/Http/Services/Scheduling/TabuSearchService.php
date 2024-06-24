<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\SemesterRepository;
use App\Http\Repositories\Scheduling\ScheduleLessonRepository;
use App\Models\MasterData\ScheduleDay;
use App\Models\Scheduling\ScheduleLesson;
use App\Models\Scheduling\ScheduleLessonItem;

class TabuSearchService
{
  use ApiResponseTrait;

  private ScheduleLessonRepository $scheduleLessonRepository;
  private SemesterRepository $semesterRepository;

  public function __construct(ScheduleLessonRepository $scheduleLessonRepository, SemesterRepository $semesterRepository)
  {
    $this->scheduleLessonRepository = $scheduleLessonRepository;
    $this->semesterRepository = $semesterRepository;
  }

  public function search($inputData)
  {
    $maxIteration = isset($inputData['max_iteration']) ?  $inputData['max_iteration'] : 100;
    $tabuSize = isset($inputData['tabu_size']) ? $inputData['tabu_size'] : 10;

    $classroomSchedules = $this->initClassroomSchedules();



    return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $classroomSchedules);
  }

  public function initClassroomSchedules()
  {
    $classroomSchedules = ScheduleLesson::all();

    foreach ($classroomSchedules as $classroomSchedule) {
      $scheduleLessonItems = ScheduleLessonItem::where('schedule_lesson_id', $classroomSchedule->id)->get()->toArray();
      $scheduleDays = ScheduleDay::orderBy('order_direction', 'asc')->get();

      // Initialize an empty array for schedules
      $schedules = [];

      foreach ($scheduleDays as $scheduleDay) {
        // Initialize an empty array for lessons
        $lessons = [];
        for ($i = 1; $i <= $scheduleDay->total_hours; $i++) {
          $lessons[] = ScheduleLessonItem::whereHas('scheduleLessonHour', function ($query) use ($i, $scheduleDay) {
            $query->whereHas('scheduleDay', function ($query) use ($scheduleDay) {
              $query->where('id', $scheduleDay->id);
            })->where('started_at', $i);
          })->first();
        }
        // Set the lessons array to the scheduleDay
        $scheduleDay->lessons = $lessons;
        // Add the scheduleDay to the schedules array
        $schedules[] = $scheduleDay;
      }

      // Set the schedules array to the classroomSchedule
      $classroomSchedule->schedules = $schedules;
    }

    return $classroomSchedules;
  }

  public function generateNewSolussions()
  {
    $classroomSchedules = ScheduleLesson::all();

    foreach ($classroomSchedules as $classroomSchedule) {
      $scheduleLessonItems = ScheduleLessonItem::where('schedule_lesson_id', $classroomSchedule->id)->get()->toArray();
      shuffle($scheduleLessonItems);
      $scheduleDays = ScheduleDay::orderBy('order_direction', 'asc')->get();

      // Initialize an empty array for schedules
      $schedules = [];

      foreach ($scheduleDays as $scheduleDay) {
        // Initialize an empty array for lessons
        $lessons = [];
        for ($i = 1; $i <= $scheduleDay->total_hours; $i++) {
          $lessons[] = array_pop($scheduleLessonItems);
        }
        // Set the lessons array to the scheduleDay
        $scheduleDay->lessons = $lessons;
        // Add the scheduleDay to the schedules array
        $schedules[] = $scheduleDay;
      }

      // Set the schedules array to the classroomSchedule
      $classroomSchedule->schedules = $schedules;
    }

    return $classroomSchedules;
  }


  public function evaluateSchedules($classroomSchedules)
  {
  }
}
