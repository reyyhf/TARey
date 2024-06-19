<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\Semester;

class SemesterRepository extends BaseRepository
{
    protected $model;

    public function __construct(Semester $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('started_year', 'asc')->get();
    }

    public function findActiveSemester()
    {
        return $this->model->where('is_active', true)->first();
    }
}
