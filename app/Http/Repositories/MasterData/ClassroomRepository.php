<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\Classroom;

class ClassroomRepository extends BaseRepository
{
    protected $model;

    public function __construct(Classroom $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }

    public function getClassroomLabel()
    {
        return $this->model->getClassroomLabel();
    }
}
