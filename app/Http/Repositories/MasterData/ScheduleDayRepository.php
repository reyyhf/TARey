<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\ScheduleDay;

class ScheduleDayRepository extends BaseRepository
{
    protected $model;

    public function __construct(ScheduleDay $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model
            ->whereHas('semester', function ($query) {
                $query->where('is_active', true);
            })
            ->with('semester')
            ->orderBy('order_direction', 'asc')
            ->get();
    }
}
