<?php

namespace Database\Seeders\MasterData;

use App\Models\MasterData\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $classrooms = [
            [
                'name' => 'X MIPA 1',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'X MIPA 2',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'X MIPA 3',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XI MIPA 1',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XI MIPA 2',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XI MIPA 3',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XII MIPA 1',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XII MIPA 2',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XII MIPA 3',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'X IPS 1',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'X IPS 2',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'X IPS 3',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'XI IPS 1',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'XI IPS 2',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'XI IPS 3',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'XII IPS 1',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'XII IPS 2',
                'majority' => 'IPS',
                'quota' => 35,
            ],
            [
                'name' => 'XII IPS 3',
                'majority' => 'IPS',
                'quota' => 35,
            ],
        ];

        foreach ($classrooms as $classroom) {
            $label = explode(' ', $classroom['name']);
            $classroom['label'] = $label[0].' '.$label[1];

            Classroom::updateOrCreate([
                'name' => $classroom['name'],
            ], $classroom);
        }
    }
}
