<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User\Role;

class RoleRepository extends BaseRepository
{
    protected $model;

    public function __construct(Role $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }
}
