<?php

namespace Database\Seeders\MasterData;

use App\Models\MasterData\Classroom;
use App\Models\MasterData\CurriculumLesson;
use App\Models\MasterData\Lesson;
use App\Models\MasterData\Semester;
use Illuminate\Database\Seeder;

class CurriculumLessonSeeder extends Seeder
{
    public function run()
    {
        $lessons = Lesson::get();
        $activeSemester = Semester::where('is_active', true)->first();
        $classrooms = Classroom::all();

        foreach ($lessons as $lesson) {
            CurriculumLesson::updateOrCreate([
                'lesson_id' => $lesson->id,
                'classroom_label' => $classrooms->random()->label,
                'semester_id' => $activeSemester->id,
                'maximum_hours_per_week' => random_int(2, 3),
            ]);
        }
    }
}
