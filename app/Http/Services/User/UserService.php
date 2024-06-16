<?php

namespace App\Http\Services\User;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\User\ProfileRepository;
use App\Http\Repositories\User\RoleRepository;
use App\Http\Repositories\User\UserRepository;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ApiResponseTrait;

    private $repository;

    private $roleRepository;

    private $profileService;

    private $profileRepository;

    public function __construct(
        UserRepository $repository,
        ProfileService $profileService,
        RoleRepository $roleRepository,
        ProfileRepository $profileRepository
    ) {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->profileService = $profileService;
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
        $users = $this->repository->index();

        $users = $users->each(function ($user, $index) {
            $user->number = $index + 1;
        });

        $response = UserResource::collection($users);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function getTeacher()
    {
        $teachers = $this->repository->getTeacher();

        $teachers = $teachers->each(function ($teacher, $index) {
            $teacher->number = $index + 1;
        });

        $response = UserResource::collection($teachers);

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $response);
    }

    public function store($inputData)
    {
        return DB::transaction(function () use ($inputData) {

            $userAttributes = [
                'email' => $inputData['email'],
                'password' => Hash::make($inputData['password']),
            ];

            $user = $this->repository->store($userAttributes);
            if (! $user) {
                DB::rollBack();
                throw new ErrorAPIException('User Gagal Ditambahkan', 400);
            }

            $selectedRole = $this->roleRepository->findColumn('name', $inputData['role_name']);

            $profileAttributes = [
                'name' => $inputData['name'],
                'nuptk' => $inputData['nuptk'],
                'gender' => $inputData['gender'],
                'birth_place' => $inputData['birth_place'],
                'user_id' => $user->id,
                'role_id' => $selectedRole->id,
                'is_active' => $inputData['is_active'],
            ];

            if (isset($inputData['user_status_id'])) {
                $profileAttributes['user_status_id'] = $inputData['user_status_id'];
            }

            if (isset($inputData['maximum_teaching_load'])) {
                $profileAttributes['maximum_teaching_load'] = $inputData['maximum_teaching_load'];
            }

            $profile = $this->profileRepository->store($profileAttributes);

            $createdProfile = $this->profileRepository->find($profile->id);

            if (isset($inputData['teacher_lessons'])) {

                $assingedClassrooms = $createdProfile->teacherLessons()->sync(
                    $inputData['teacher_lessons']
                );

                if (! $assingedClassrooms) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Ditambahkan', 400);
                }
            }

            if (isset($inputData['teacher_classrooms'])) {

                $assingedClassrooms = $createdProfile->teacherClassrooms()->sync(
                    $inputData['teacher_classrooms']
                );

                if (! $assingedClassrooms) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Ditambahkan', 400);
                }
            }

            if (! $profile) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Ditambahkan');
            }

            $result = new UserResource($user);

            return $this->resultResponse('success', 'Data Berhasil Ditambahkan', 201, $result);
        });
    }

    public function show($id)
    {
        $user = $this->repository->find($id);

        return new UserResource($user);
    }

    public function update($id, $inputData)
    {
        return DB::transaction(function () use ($id, $inputData) {

            $userAttributes = [
                'email' => $inputData['email'],
            ];

            $user = $this->repository->update($id, $userAttributes);
            if (! $user) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Diubah', 400);
            }

            $selectedRole = $this->roleRepository->findColumn('name', $inputData['role_name']);

            $profileAttributes = [
                'name' => $inputData['name'],
                'nuptk' => $inputData['nuptk'],
                'gender' => $inputData['gender'],
                'birth_place' => $inputData['birth_place'],
                'user_id' => $user->id,
                'role_id' => $selectedRole->id,
                'is_active' => $inputData['is_active'],
            ];

            if (isset($inputData['user_status_id'])) {
                $profileAttributes['user_status_id'] = $inputData['user_status_id'];
            }

            if (isset($inputData['maximum_teaching_load'])) {
                $profileAttributes['maximum_teaching_load'] = $inputData['maximum_teaching_load'];
            }

            $profile = $this->profileService->update($id, $profileAttributes);

            $updatedProfile = $this->profileRepository->findColumn('user_id', $id);

            if (isset($inputData['teacher_lessons'])) {

                $assignedLessons = $updatedProfile->teacherLessons()->sync($inputData['teacher_lessons']);

                if (! $assignedLessons) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Ditambahkan', 400);
                }
            }

            if (isset($inputData['teacher_classrooms'])) {

                $assingedClassrooms = $updatedProfile->teacherClassrooms()->sync(
                    $inputData['teacher_classrooms']
                );

                if (! $assingedClassrooms) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Ditambahkan', 400);
                }
            }

            if (! $profile) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Diubah', 500);
            }

            $result = new UserResource($user);

            return $this->resultResponse('success', 'Data Berhasil Diubah', 200, $result);
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $selectedProfile = $this->profileRepository->findColumn('user_id', $id);

            $existedLessons = $selectedProfile->teacherLessons();
            $existedClassrooms = $selectedProfile->teacherClassrooms();

            if ($existedLessons->count() > 0) {
                $deletedLessons = $selectedProfile->teacherLessons()->detach();

                if (! $deletedLessons) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Dihapus', 500);
                }
            }

            if ($existedClassrooms->count() > 0) {
                $deletedClassrooms = $selectedProfile->teacherClassrooms()->detach();

                if (! $deletedClassrooms) {
                    DB::rollBack();
                    throw new ErrorAPIException('Data Gagal Dihapus', 500);
                }
            }

            $profile = $this->profileService->destroy($id);

            if (! $profile) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Dihapus', 500);
            }

            $user = $this->repository->destroy($id);

            if (! $user) {
                DB::rollBack();
                throw new ErrorAPIException('Data Gagal Dihapus', 500);
            }

            return $this->resultResponse('success', 'Data Berhasil Dihapus', 200);
        });
    }
}
