<?php

namespace Database\Seeders;

use Database\Seeders\MasterData\ClassroomSeeder;
use Database\Seeders\MasterData\CurriculumLessonSeeder;
use Database\Seeders\MasterData\LessonCategorySeeder;
use Database\Seeders\MasterData\LessonSeeder;
use Database\Seeders\MasterData\RoleSeeder;
use Database\Seeders\MasterData\ScheduleLessonHourSeeder;
use Database\Seeders\MasterData\SemesterSeeder;
use Database\Seeders\MasterData\UserStatusSeeder;
use Database\Seeders\User\ProfileSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserStatusSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ProfileSeeder::class,
            LessonCategorySeeder::class,
            SemesterSeeder::class,
            ClassroomSeeder::class,
            LessonSeeder::class,
            CurriculumLessonSeeder::class,
            ScheduleLessonHourSeeder::class,
        ]);
    }
}
