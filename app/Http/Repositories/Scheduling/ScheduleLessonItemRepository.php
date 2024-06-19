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
    return $this->model->with(['lesson', 'teacher', 'scheduleLesson', 'scheduleLessonHour'])->orderBy('created_at', 'desc')->get();
  }

  public function findScheduleLessonItem($id)
  {
    return $this->model->with(['lesson', 'teacher', 'scheduleLesson', 'scheduleLessonHour'])->where('id', $id)->first();
  }
}
