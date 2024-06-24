<?php

namespace App\Http\Repositories\Scheduling;

use App\Http\Repositories\BaseRepository;
use App\Models\Scheduling\ScheduleLesson;

class ScheduleLessonRepository extends BaseRepository
{
  protected $model;

  public function __construct(ScheduleLesson $model)
  {
    parent::__construct($model);
    $this->model = $model;
  }

  public function index()
  {
    return $this->model->with(['semester', 'classroom', 'scheduleLessonItems.scheduleLessonHour', 'scheduleLessonItems.lesson', 'scheduleLessonItems.teacher', 'scheduleLessonItems.scheduleLessonHour.scheduleDay'])->orderBy('created_at', 'desc')->get();
  }

  public function findScheduleLesson($id)
  {
    return $this->model->with(['semester', 'classroom', 'scheduleLessonItems.scheduleLessonHour', 'scheduleLessonItems.lesson', 'scheduleLessonItems.teacher', 'scheduleLessonItems.scheduleLessonHour.scheduleDay'])->where('id', $id)->first();
  }
}
