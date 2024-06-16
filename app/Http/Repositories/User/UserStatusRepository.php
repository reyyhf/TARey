<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User\UserStatus;

class UserStatusRepository extends BaseRepository
{
    protected $model;

    public function __construct(UserStatus $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }
}
