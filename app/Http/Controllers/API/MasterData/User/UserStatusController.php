<?php

namespace App\Http\Controllers\API\MasterData\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\User\CreateUserStatusValidation;
use App\Http\Requests\API\MasterData\User\UpdateUserStatusValidation;
use App\Http\Services\User\UserStatusService;

class UserStatusController extends Controller
{
    protected $service;

    public function __construct(UserStatusService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $userStatuses = $this->service->index();

        return $this->serviceResponseHandler($userStatuses);
    }

    public function store(CreateUserStatusValidation $request)
    {
        $inputData = $request->validated();

        $createUserStatus = $this->service->store($inputData);

        return $this->serviceResponseHandler($createUserStatus);
    }

    public function show($id)
    {
        $userStatus = $this->service->show($id);

        return $this->serviceResponseHandler($userStatus);
    }

    public function update(UpdateUserStatusValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateUserStatus = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateUserStatus);
    }

    public function destroy($id)
    {
        $deleteUserStatus = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteUserStatus);
    }
}
