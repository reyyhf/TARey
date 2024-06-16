<?php

namespace App\Http\Controllers\API\MasterData\User;

use App\Http\Controllers\Controller;
use App\Http\Services\User\RoleService;

class RoleController extends Controller
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $roles = $this->service->index();

        return $this->serviceResponseHandler($roles);
    }
}
