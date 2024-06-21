<?php

namespace App\Http\Repositories\Scheduling;

use App\Http\Repositories\BaseRepository;
use App\Models\Scheduling\CriteriaConstraint;

class CriteriaConstraintRepository extends BaseRepository
{

    protected $model;

    public function __construct(CriteriaConstraint $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
}
