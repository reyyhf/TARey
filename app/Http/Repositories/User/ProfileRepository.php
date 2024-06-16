<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User\Profile;

class ProfileRepository extends BaseRepository
{
    protected $model;

    public function __construct(Profile $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}
