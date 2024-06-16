<?php

namespace App\Http\Services\User;

use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\User\ProfileRepository;
use App\Http\Resources\User\ProfileResource;

class ProfileService
{
    use ApiResponseTrait;

    private $repository;

    public function __construct(ProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($inputData)
    {
        $profile = $this->repository->store($inputData);

        if (! $profile) {
            return $this->resultResponse('error', 'Data Gagal Ditambahkan', 500);
        }

        $result = new ProfileResource($profile);

        return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
    }

    public function show($id)
    {
        $profile = $this->repository->find($id);

        return new ProfileResource($profile);
    }

    public function update($userId, $inputData)
    {
        $profile = $this->repository->findColumn('user_id', $userId);

        $updatedProfile = $profile->update($inputData);

        if (! $updatedProfile) {
            return $this->resultResponse('error', 'Data Gagal Diubah', 500);
        }

        $result = new ProfileResource($profile);

        return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
    }

    public function destroy($userId)
    {
        $profile = $this->repository->findColumn('user_id', $userId);

        $deletedProfile = $profile->delete();

        if (! $deletedProfile) {
            return $this->resultResponse('error', 'Data Gagal Dihapus', 500);
        }

        return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
    }
}
