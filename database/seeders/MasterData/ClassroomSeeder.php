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
                'name' => 'X IPA 1',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'X IPA 2',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'X IPA 3',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XI IPA 1',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XI IPA 2',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XI IPA 3',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XII IPA 1',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XII IPA 2',
                'majority' => 'IPA',
                'quota' => 35,
            ],
            [
                'name' => 'XII IPA 3',
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
            $classroom['label'] = $label[0] . ' ' . $label[1];

            Classroom::updateOrCreate([
                'name' => $classroom['name'],
            ], $classroom);
        }
    }
}
