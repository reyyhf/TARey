<?php

namespace App\Http\Services\User;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\User\UserStatusRepository;
use App\Http\Resources\User\UserStatusResource;

class UserStatusService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(UserStatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $usersStatuses = $this->repository->index();

        $usersStatuses = $usersStatuses->each(function ($role, $index) {
            $role->number = $index + 1;
        });

        $response = UserStatusResource::collection($usersStatuses);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        $userStatus = $this->repository->store($inputData);

        if (! $userStatus) {
            return $this->resultResponse('error', 'Data Gagal Ditambahkan', 500);
        }

        $result = new UserStatusResource($userStatus);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $userStatus = $this->repository->find($id);

        $response = new UserStatusResource($userStatus);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        $userStatus = $this->repository->update($id, $inputData);

        if (! $userStatus) {
            throw new ErrorAPIException('Data Gagal Diubah', 500);
        }

        $result = new UserStatusResource($userStatus);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($id)
    {
        $userStatus = $this->repository->destroy($id);

        if (! $userStatus) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
