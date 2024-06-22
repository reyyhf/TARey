<?php

namespace App\Http\Services\Scheduling;

use App\Helpers\ApiResponseTrait;
use App\Http\Repositories\Scheduling\CriteriaConstraintRepository;

class CriteriaConstraintService
{
    use ApiResponseTrait;

    private CriteriaConstraintRepository $repository;


    public function __construct(CriteriaConstraintRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $criteriaConstraints = $this->repository->index();

        return $this->resultResponse('success', 'Data Berhasil Ditampilkan', 200, $criteriaConstraints);
    }

    public function store($inputData)
    {
        $dynamicMaxTeach = $this->repository->findIsDynamicAndMaxTeach();
        $dynamicMaxSubject = $this->repository->findIsDynamicAndMaxSubject();

        if (!$dynamicMaxTeach || !$dynamicMaxSubject) {
            $inputData['type'] = 'hard';
            $inputData['is_dynamic'] = true;
            $inputData['constraint'] = 'Guru tidak boleh mengajar melebihi dari maksimal ' . $inputData['max_teaching_hours'] .
                ' jam mengajar perhari dalam satu mata pelajaran di kelas yang sama. Jam maksimal mata pelajaran berurutan adalah ' . $inputData['max_subject_hours'] . ' jam perhari';
            $criteriaConstraint = $this->repository->store($inputData);
        } else {
            $id = $dynamicMaxTeach->id;
            $inputData['type'] = 'hard';
            $inputData['is_dynamic'] = true;
            $inputData['constraint'] = 'Guru tidak boleh mengajar melebihi dari maksimal ' . $inputData['max_teaching_hours'] .
                ' jam mengajar perhari dalam satu mata pelajaran di kelas yang sama. Jam maksimal mata pelajaran berurutan adalah ' . $inputData['max_subject_hours'] . ' jam perhari';
            $criteriaConstraint = $this->repository->update($id, $inputData);
        }

        return $this->resultResponse('success', 'Data berhasil ditambahnkan', 200, $criteriaConstraint);
    }

}
