<?php

namespace App\Http\Controllers\API\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\Semester\CreateSemesterValidation;
use App\Http\Requests\API\MasterData\Semester\UpdateSemesterValidation;
use App\Http\Services\MasterData\SemesterService;

class SemesterController extends Controller
{
    protected $service;

    public function __construct(SemesterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $semesters = $this->service->index();

        return $this->serviceResponseHandler($semesters);
    }

    public function findActiveSemester()
    {
        $activeSemester = $this->service->findActiveSemester();

        return $this->serviceResponseHandler($activeSemester);
    }

    public function store(CreateSemesterValidation $request)
    {
        $inputData = $request->validated();

        $createSemester = $this->service->store($inputData);

        return $this->serviceResponseHandler($createSemester);
    }

    public function show($id)
    {
        $semester = $this->service->show($id);

        return $this->serviceResponseHandler($semester);
    }

    public function update(UpdateSemesterValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateSemester = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateSemester);
    }

    public function destroy($id)
    {
        $deleteSemester = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteSemester);
    }
}
