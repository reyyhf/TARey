<?php

namespace Database\Seeders\User;

use App\Models\MasterData\Classroom;
use App\Models\MasterData\Lesson;
use App\Models\User;
use App\Models\User\Profile;
use App\Models\User\Role;
use App\Models\User\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $role = Role::whereName('Guru')->first();
        $userStatus = UserStatus::pluck("id");
        $gender = [0, 1];
        $userCount = 20;
        $lessons = Lesson::pluck('id')->toArray();
        $classrooms = Classroom::pluck('id')->toArray();

        for ($i = 0; $i < $userCount; $i++) {

            $user = User::create([
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);

            $randomGender = array_rand($gender);

            $profile = Profile::create([
                'user_id' => $user->id,
                'role_id' => $role->id,
                'user_status_id' => $userStatus->random(),
                'nuptk' => strval($faker->randomNumber(6, true)),
                'name' => $faker->name,
                'gender' => $gender[$randomGender],
                'birth_place' => $faker->city(),
                'is_active' => 1,
                'maximum_teaching_load' => 2
            ]);

            $numberOfLessons = rand(1, 3);
            $selectedLessons = [];

            for ($j = 0; $j < $numberOfLessons; $j++) {
                do {
                    $lessonId = $faker->randomElement($lessons);
                    $classroomId = $faker->randomElement($classrooms);
                    $combination = $lessonId . '-' . $classroomId;
                } while (in_array($combination, $selectedLessons));

                $selectedLessons[] = $combination;

                $profile->teacherLessons()->attach($lessonId, ['classroom_id' => $classroomId]);
            }

        }
    }
}
