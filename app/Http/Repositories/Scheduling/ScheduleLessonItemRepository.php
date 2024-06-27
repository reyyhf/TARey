<?php

namespace App\Http\Repositories\Scheduling;

use App\Http\Repositories\BaseRepository;
use App\Models\Scheduling\ScheduleLessonItem;

class ScheduleLessonItemRepository extends BaseRepository
{
  protected $model;

  public function __construct(ScheduleLessonItem $model)
  {
    parent::__construct($model);
    $this->model = $model;
  }

  public function index()
  {
    return $this->model->with(['lesson', 'teacher', 'scheduleLesson', 'scheduleLessonHour.scheduleDay'])->orderBy('created_at', 'desc')->get();
  }

  public function findScheduleLessonItems($scheduleLessonId)
  {
    return $this->model->with(['lesson', 'teacher', 'scheduleLesson', 'scheduleLessonHour.scheduleDay'])->where('schedule_lesson_id', $scheduleLessonId)->orderBy('created_at', 'desc')->get();
  }

  public function findScheduleLessonItem($id)
  {
    return $this->model->with(['lesson', 'teacher', 'scheduleLesson', 'scheduleLessonHour.scheduleDay'])->where('id', $id)->first();
  }

  public function isConflict($scheduleLessonId, $scheduleLessonHourId)
  {
    return $this->model->where('schedule_lesson_id', $scheduleLessonId)->where('schedule_lesson_hour_id', $scheduleLessonHourId)->exists();
  }
}
