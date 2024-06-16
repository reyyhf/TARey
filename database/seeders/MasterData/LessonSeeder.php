<?php

namespace Database\Seeders\MasterData;

use App\Models\MasterData\Lesson;
use App\Models\MasterData\LessonCategory;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessonCategories = LessonCategory::all();

        $lessons = [
            [
                'lesson_category_id' => $lessonCategories->random()->id,
                'name' => 'Fisika',
                'acronym' => 'FIS',
            ],
            [
                'lesson_category_id' => $lessonCategories->random()->id,
                'name' => 'Matematika',
                'acronym' => 'MAT',
            ],
            [
                'lesson_category_id' => $lessonCategories->random()->id,
                'name' => 'Kimia',
                'acronym' => 'KIM',
            ],
            [
                'lesson_category_id' => $lessonCategories->random()->id,
                'name' => 'Biologi',
                'acronym' => 'BIO',
            ],
            [
                'lesson_category_id' => $lessonCategories->random()->id,
                'name' => 'Akuntansi',
                'acronym' => 'AKT',
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::updateOrCreate([
                'name' => $lesson['name'],
            ], $lesson);
        }
    }
}
