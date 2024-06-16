<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\ScheduleLessonHour;

class ScheduleLessonHourRepository extends BaseRepository
{
    protected $model;

    public function __construct(ScheduleLessonHour $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index($scheduleDayId)
    {
        return $this->model->getByDay($scheduleDayId)->get();
    }

    public function findExistedHour($scheduleDayId, $startedAt)
    {
        return $this->model->findExistedHour($scheduleDayId, $startedAt);
    }

    public function countMaximumBreakHours()
    {
        return $this->model->countMaximumBreakHours();
    }

    public function getByOrderDirection($scheduleDayId, $orderDirection = [])
    {
        return $this->model->getByOrderDirection($scheduleDayId, $orderDirection);
    }
}
