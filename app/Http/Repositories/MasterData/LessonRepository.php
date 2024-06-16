<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\Lesson;

class LessonRepository extends BaseRepository
{
    protected $model;

    public function __construct(Lesson $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model
            ->with([
                'lessonCategory',
            ])
            ->orderBy('name', 'asc')->get();
    }

    public function getCurriculumClassrooms()
    {
        return $this->model
            ->with([
                'lessonCategory',
                'classrooms',
            ])
            ->whereHas('classrooms')
            ->orderBy('name', 'asc')
            ->get();
    }
}
