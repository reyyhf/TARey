<?php

namespace App\Http\Services\User;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\User\RoleRepository;
use App\Http\Resources\User\RoleResource;

class RoleService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $roles = $this->repository->index();

        $roles = $roles->each(function ($role, $index) {
            $role->number = $index + 1;
        });

        $response = RoleResource::collection($roles);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        $role = $this->repository->store($inputData);

        if (! $role) {
            throw new ErrorAPIException('Data Gagal Ditambahkan', 500);
        }

        $result = new RoleResource($role);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $role = $this->repository->find($id);

        $response = new RoleResource($role);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function update($id, $inputData)
    {
        $role = $this->repository->update($id, $inputData);

        if (! $role) {
            throw new ErrorAPIException('Data Gagal Diubah', 500);
        }

        $result = new RoleResource($role);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($id)
    {
        $role = $this->repository->destroy($id);

        if (! $role) {
            throw new ErrorAPIException('Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
