<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    protected function fetchUserData($roleNames = [])
    {
        return $this->model
            ->whereHas('profile.role', function ($query) use ($roleNames) {
                $query->whereIn('name', $roleNames);
            })
            ->with([
                'profile',
                'profile.role',
                'profile.userStatus',
                'profile.teacherLessons',
            ])
            ->get();
    }

    public function index()
    {
        return $this->fetchUserData(['Tata Usaha', 'Kurikulum', 'Guru']);
    }

    public function getTeacher()
    {
        return $this->fetchUserData(['Guru']);
    }
}
