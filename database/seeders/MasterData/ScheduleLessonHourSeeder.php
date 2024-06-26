<?php

namespace Database\Seeders\MasterData;

use App\Models\MasterData\ScheduleDay;
use App\Models\MasterData\ScheduleLessonHour;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleLessonHourSeeder extends Seeder
{
    public function run()
    {
        $scheduleDays = ScheduleDay::all();


        $data = [];

        foreach ($scheduleDays as $scheduleDay) {
            $startedDuration = Carbon::parse('06:40');
            for ($i = 1; $i <= $scheduleDay->total_hours; $i++) {
                $data[] = [
                    'schedule_day_id' => $scheduleDay->id,
                    'started_at' => $i,
                    'ended_at' => $i + 1,
                    'started_duration' => $startedDuration->format('H:i'),
                    'ended_duration' => $startedDuration->addMinutes(50)->format('H:i'),
                    'order_direction' => $i,
                    'is_break_hour' => 0,
                ];
            }
        }

        foreach ($data as $item) {
            ScheduleLessonHour::updateOrCreate([
                'schedule_day_id' => $item['schedule_day_id'],
                'started_at' => $item['started_at'],
            ], $item);
        }
    }
}
