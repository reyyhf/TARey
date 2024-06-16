<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\LessonCategory;

class LessonCategoryRepository extends BaseRepository
{
    protected $model;

    public function __construct(LessonCategory $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }
}
