<?php

namespace Database\Seeders\MasterData;

use App\Models\MasterData\LessonCategory;
use Illuminate\Database\Seeder;

class LessonCategorySeeder extends Seeder
{
    public function run()
    {
        $lessonCategories = [
            [
                'name' => 'Kelompok A (Wajib)',
            ],
            [
                'name' => 'Kelompok B (Wajib)',
            ],
            [
                'name' => 'Kelompok C (Peminatan Akademik)',
            ],
            [
                'name' => 'Muatan Lokal',
            ],
            [
                'name' => 'Pengembangan Diri',
            ],
            [
                'name' => 'Pelajaran Lintas Minat',
            ],
        ];

        foreach ($lessonCategories as $lessonCategory) {
            LessonCategory::updateOrCreate([
                'name' => $lessonCategory['name'],
            ], $lessonCategory);
        }
    }
}
