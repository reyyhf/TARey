<?php

namespace App\Http\Repositories\MasterData;

use App\Http\Repositories\BaseRepository;
use App\Models\MasterData\CurriculumLesson;

class CurriculumLessonRepository extends BaseRepository
{
    protected $model;

    public function __construct(CurriculumLesson $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->getByLesson();
    }

    public function find($id)
    {
        return $this->model
            ->where('lesson_id', $id)
            ->with([
                'lessons',
                'semester',
            ])
            ->get()
            ->groupBy('lesson_id');
    }

    public function destroy($id)
    {
        return $this->model
            ->where('lesson_id', $id)
            ->delete();
    }
}
