<?php

namespace App\Http\Services\Scheduling;

use App\Helpers\ApiResponseTrait;
use App\Models\MasterData\Classroom;
use App\Models\MasterData\ScheduleDay;
use App\Models\Scheduling\ScheduleReport;
use App\Models\User\Profile;
use App\Models\User\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScheduleReportService
{
    use ApiResponseTrait;

    public function index()
    {
        $reports = ScheduleReport::all()->toArray();

        foreach ($reports as &$report) {
            $report['data'] = json_decode($report['data']);
        }

        return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $reports);
    }

    public function show($id)
    {
        $report = ScheduleReport::where('id', $id)->first();

        $report['data'] = json_decode($report['data']);
        $report['data_teaching_weight'] = json_decode($report['data_teaching_weight']);

        return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $report);
    }

    public function dashboard()
    {
        $report = ScheduleReport::latest()->first();
        $teacherHonorary = Profile::with('userStatus')->whereHas('userStatus', function ($query) {
            $query->whereName('Honorer');
        })->get();
        $teacherPermanent = Profile::with('userStatus')->whereHas('userStatus', function ($query) {
            $query->whereName('Tetap');
        })->get();

        $report['data'] = json_decode($report['data']);
        $report['teacherHonorary'] = $teacherHonorary;
        $report['teacherPermanent'] = $teacherPermanent;


        return $this->resultResponse('success', 'Data berhasil ditampilkan', 200, $report);
    }

    public function store($inputData)
    {
        $report = ScheduleReport::create(
            [
                'title' => $inputData['title'],
                'data' => $inputData['data'],
                'reported_by' => Auth::user()->id,
                'data_teaching_weight' => $this->teachingWeight($inputData['data'])
            ]
        );

        return $this->resultResponse('success', 'Data berhasil ditambahkan', 200, $report);
    }

    public function teachingWeight($data)
    {
        $role = Role::where('name', 'Guru')->first();
        $teachers = Profile::where('role_id', $role->id)->get()->toArray();


        foreach ($teachers as &$teacher) {
            $classrooms = Classroom::orderBy('name', 'asc')->get()->toArray();
            $teacher['classrooms'] = $classrooms;

            foreach ($teacher['classrooms'] as &$classroom) {
                $scheduleDays = ScheduleDay::orderBy('order_direction', 'asc')->get()->toArray();
                $classroom['schedules'] = $scheduleDays;

                foreach ($classroom['schedules'] as &$day) {
                    $day['lessons'] = [];
                    for ($i = 0; $i < $day['total_hours']; $i++) {
                        $day['lessons'][] = $this->findLessonFromData(json_decode($data), $classroom['id'], $teacher['id'], $day['id'], $i);
                    }
                }
            }
        }

        return json_encode($teachers);
    }

    private function findLessonFromData($data, $classroomId, $teacherId, $dayId, $lessonIndex)
    {
        foreach ($data->result as $scheduleClassroom) {
            foreach ($scheduleClassroom->schedules as $day) {
                foreach ($day->lessons as $index => $lesson) {
                    if ($classroomId == $scheduleClassroom->classroom_id && $dayId == $day->id && $lessonIndex == $index) {
                        if ($lesson && $lesson->teacher_id == $teacherId) {
                            return $lesson;
                        }
                    }
                }
            }
        }

        return null;
    }

    public function destroy($id)
    {
        $report = ScheduleReport::find($id);
        $report->delete();

        return $this->resultResponse('success', 'Data berhasil dihapus', 200, $report);
    }
}
