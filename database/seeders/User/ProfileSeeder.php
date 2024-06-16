<?php

namespace Database\Seeders\User;

use App\Models\User;
use App\Models\User\Profile;
use App\Models\User\Role;
use App\Models\User\UserStatus;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        $userTataUsaha = User::where('email', 'tata-usaha@mailinator.com')->first();
        $userKurikulum = User::where('email', 'kurikulum@mailinator.com')->first();
        $userGuru = User::where('email', 'guru@mailinator.com')->first();

        $roleTataUsaha = Role::where('name', 'Tata Usaha')->first();
        $roleKurikulum = Role::where('name', 'Kurikulum')->first();
        $roleGuru = Role::where('name', 'Guru')->first();

        $userStatuses = UserStatus::get();

        $profiles = [
            [
                'user_id' => $userTataUsaha->id,
                'role_id' => $roleTataUsaha->id,
                'name' => 'Staff Tata Usaha',
                'nuptk' => '123456789',
                'gender' => 0,
                'birth_place' => 'Surabaya',
            ],
            [
                'user_id' => $userKurikulum->id,
                'role_id' => $roleKurikulum->id,
                'name' => 'Staff Kurikulum',
                'nuptk' => '112255533',
                'gender' => 1,
                'birth_place' => 'Surabaya',
            ],
            [
                'user_id' => $userGuru->id,
                'role_id' => $roleGuru->id,
                'user_status_id' => $userStatuses[1]->id,
                'name' => 'Guru Mata Pelajaran Test',
                'nuptk' => '65844657',
                'gender' => 1,
                'birth_place' => 'Surabaya',
                'maximum_teaching_load' => 4,
            ],
        ];

        foreach ($profiles as $profile) {
            Profile::updateOrCreate([
                'user_id' => $profile['user_id'],
                'nuptk' => $profile['nuptk'],
            ], $profile);
        }
    }
}
