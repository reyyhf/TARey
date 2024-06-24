<?php

namespace App\Http\Services\Scheduling;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\MasterData\SemesterRepository;
use App\Http\Repositories\Scheduling\ScheduleLessonRepository;
use App\Models\MasterData\ScheduleDay;
use App\Models\Scheduling\CriteriaConstraint;
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

    $scheduleDays = ScheduleDay::orderBy('order_direction', 'asc')->get()->toArray();
    $scheduleClassrooms = $this->initSolutions($scheduleDays);
    $newScheduleClassrooms = $this->generateNewSolution($scheduleClassrooms);
    test($this->evaluateSchedules($newScheduleClassrooms));


    return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $newScheduleClassrooms);
  }

  public function initSolutions($scheduleDays)
  {
    $scheduleClassrooms = ScheduleLesson::with('classroom')->get()->toArray();

    foreach ($scheduleClassrooms as &$scheduleClassroom) {

      // Initialize an empty array for schedules
      $schedules = [];

      foreach ($scheduleDays as $scheduleDay) {
        // Initialize an empty array for lessons
        $lessons = [];
        for ($i = 1; $i <= $scheduleDay['total_hours']; $i++) {
          $lesson = ScheduleLessonItem::with('lesson', 'teacher')->whereHas('scheduleLessonHour', function ($query) use ($i, $scheduleDay, $scheduleClassroom) {
            $query->whereHas('scheduleDay', function ($query) use ($scheduleDay) {
              $query->where('id', $scheduleDay['id']);
            })->where('started_at', $i)->where('schedule_lesson_id', $scheduleClassroom['id']);
          })->first();

          unset($lesson['schedule_lesson_hour_id']);

          $lessons[] = $lesson;
        }
        // Set the lessons array to the scheduleDay
        $scheduleDay['lessons'] = $lessons;
        // Add the scheduleDay to the schedules array
        $schedules[] = $scheduleDay;
      }

      // Set the schedules array to the scheduleClassroom
      $scheduleClassroom['schedules'] = $schedules;
    }

    return $scheduleClassrooms;
  }

  public function generateNewSolution($scheduleClassrooms)
  {
    $scheduleClassrooms = $this->deepClone($scheduleClassrooms);

    foreach ($scheduleClassrooms as &$scheduleClassroom) {
      $scheduleLessonItems = [];

      foreach ($scheduleClassroom['schedules'] as $day) {
        foreach ($day['lessons'] as $lesson) {
          if ($lesson) {
            $scheduleLessonItems[] = $lesson;
          }
        }
      }

      shuffle($scheduleLessonItems);

      foreach ($scheduleClassroom['schedules'] as &$day) {
        foreach ($day['lessons'] as $index => &$lesson) {
          if ($lesson) {
            $day['lessons'][$index] = array_pop($scheduleLessonItems);
          }
        }
      }
    }

    return $scheduleClassrooms;
  }

  public function evaluateSchedules($scheduleClassrooms)
  {
    $constraint = CriteriaConstraint::where('is_dynamic', true)->first();

    $maxTeachingHours = $constraint->max_teaching_hours;
    $maxSubjectHours = $constraint->max_subject_hours;

    // Check constraint
    foreach ($scheduleClassrooms as &$scheduleClassroom) {
      foreach ($scheduleClassroom['schedules'] as &$day) {
        foreach ($day['lessons'] as $index => &$lesson) {
          if (!$lesson) continue;

          $conflict = $this->checkTeacherConflictById($scheduleClassrooms, $lesson['teacher']['id']);
          if ($conflict['conflict']) {
            if (isset($lesson['score'])) {
              $lesson['score'] += 20;
            } else {
              $lesson['score'] = 20;
            }
          } else {
            $lesson['score'] = 0;
          }
        }
      }
    }

    return $scheduleClassrooms;
  }

  function checkTeacherConflictById($scheduleClassrooms, $teacherId)
  {
    $teacherSchedules = [];

    foreach ($scheduleClassrooms as $scheduleClassroom) {
      foreach ($scheduleClassroom['schedules'] as $day) {
        foreach ($day['lessons'] as $lesson) {
          if ($lesson && $lesson['teacher_id'] === $teacherId) {
            $dayName = $day['name'];
            $hourIndex = array_search($lesson, $day['lessons']);

            if (!isset($teacherSchedules[$dayName])) {
              $teacherSchedules[$dayName] = [];
            }

            if (in_array($hourIndex, $teacherSchedules[$dayName])) {
              return [
                'conflict' => true,
                'teacher_id' => $teacherId,
                'day' => $dayName,
                'hour' => $hourIndex
              ];
            }

            $teacherSchedules[$dayName][] = $hourIndex;
          }
        }
      }
    }

    return ['conflict' => false];
  }

  function deepClone($array)
  {
    return unserialize(serialize($array));
  }
}
