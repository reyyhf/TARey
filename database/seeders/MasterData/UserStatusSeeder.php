<?php

namespace Database\Seeders\MasterData;

use App\Models\User\UserStatus;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    public function run()
    {
        $userStatuses = [
            [
                'name' => 'Tetap',
                'minimum_teach_load_hour' => 2,
            ],
            [
                'name' => 'Honorer',
                'minimum_teach_load_hour' => 4,
            ],
        ];

        foreach ($userStatuses as $status) {
            UserStatus::updateOrCreate([
                'name' => $status['name'],
            ], $status);
        }
    }
}
