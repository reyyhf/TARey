<?php

namespace Database\Seeders\MasterData;

use App\Models\User\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Tata Usaha',
            ],
            [
                'name' => 'Guru',
            ],
            [
                'name' => 'Kurikulum',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate([
                'name' => $role['name'],
            ], $role);
        }
    }
}
