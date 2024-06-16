<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'email' => 'tata-usaha@mailinator.com',
                'password' => Hash::make('tatausaha123'),
            ],
            [
                'email' => 'kurikulum@mailinator.com',
                'password' => Hash::make('kurikulum123'),
            ],
            [
                'email' => 'guru@mailinator.com',
                'password' => Hash::make('guru123'),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'email' => $user['email'],
            ], $user);
        }
    }
}
