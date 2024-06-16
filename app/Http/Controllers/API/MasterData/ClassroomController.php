<?php

namespace App\Http\Controllers\API\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterData\Classroom\CreateClassroomValidation;
use App\Http\Requests\API\MasterData\Classroom\UpdateClassroomValidation;
use App\Http\Services\MasterData\ClassroomService;

class ClassroomController extends Controller
{
    protected $service;

    public function __construct(ClassroomService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $classrooms = $this->service->index();

        return $this->serviceResponseHandler($classrooms);
    }

    public function getClassroomLabel()
    {
        $labels = $this->service->getClassroomLabel();

        return $this->serviceResponseHandler($labels);
    }

    public function store(CreateClassroomValidation $request)
    {
        $inputData = $request->validated();

        $createClassroom = $this->service->store($inputData);

        return $this->serviceResponseHandler($createClassroom);
    }

    public function show($id)
    {
        $classroom = $this->service->show($id);

        return $this->serviceResponseHandler($classroom);
    }

    public function update(UpdateClassroomValidation $request, $id)
    {
        $inputData = $request->validated();

        $updateClassroom = $this->service->update($id, $inputData);

        return $this->serviceResponseHandler($updateClassroom);
    }

    public function destroy($id)
    {
        $deleteClassroom = $this->service->destroy($id);

        return $this->serviceResponseHandler($deleteClassroom);
    }
}
