<?php

namespace App\Http\Controllers\API\MasterData\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\User\CreateUserValidation;
use App\Http\Requests\API\MasterData\User\UpdateUserValidation;
use App\Http\Services\User\UserService;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->index();

        return $this->serviceResponseHandler($users);
    }

    public function getTeacher()
    {
        $teachers = $this->service->getTeacher();

        return $this->serviceResponseHandler($teachers);
    }

    public function store(CreateUserValidation $request)
    {
        $inputData = $request->validated();

        $createUser = $this->service->store($inputData);

        return $this->serviceResponseHandler($createUser);
    }

    public function show($id)
    {
        $user = $this->service->show($id);

        return $this->serviceResponseHandler($user);
    }

    public function update(UpdateUserValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateUser = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateUser);
    }

    public function destroy($id)
    {
        $deleteUser = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteUser);
    }
}
