<?php

namespace Database\Seeders\MasterData;

use App\Models\MasterData\ScheduleDay;
use App\Models\MasterData\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesters = [
            [
                'started_year' => '2024',
                'ended_year' => '2025',
                'is_active' => 1,
            ],
        ];

        $scheduleDays = config('schedule-features.schedule-days');

        foreach ($semesters as $semester) {
            $semester = Semester::updateOrCreate([
                'started_year' => $semester['started_year'],
            ], $semester);

            foreach ($scheduleDays as $scheduleDay) {
                $scheduleDay['semester_id'] = $semester->id;
                ScheduleDay::updateOrCreate([
                    'semester_id' => $scheduleDay['semester_id'],
                    'name' => $scheduleDay['name'],
                ], $scheduleDay);
            }
        }
    }
}
