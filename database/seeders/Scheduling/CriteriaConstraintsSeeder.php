<?php

namespace Database\Seeders\Scheduling;

use App\Models\Scheduling\CriteriaConstraint;
use Illuminate\Database\Seeder;

class CriteriaConstraintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $criteriaConstraints = [
            [
                "constraint" => "Guru yang mengajar tidak boleh mengajar lebih dari satu kelas atau mengajar di lain kelas pada waktu yang sama",
                "type" => "hard",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Bobot mata pelajaran tidak melebihi dari kurikulum yang telah ditentukan",
                "type" => "hard",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Jam belajar dimulai pukul 06:40-16:00 WIB untuk hari Senin sampai Kamis sedangkan untuk hari Jumat dimulai pukul 06:40-11:15 WIB.",
                "type" => "hard",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Jam istirahat siswa pada hari Senin sampai Kamis berjalan 2 kali dimulai pukul 09:45-10:00 WIB dan 11:30-12:00 WIB.",
                "type" => "hard",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Maksimal kegiatan belajar mengajar adalah 10 jam perhari, khusus hari jum’at 6 jam perhari.",
                "type" => "hard",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Guru mengajar minimal 2 hari bagi guru yang sekolah induknya bukan SMA tersebut",
                "type" => "soft",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Guru mengajar minimal 4 hari bagi guru yang sekolah induknya adalah SMA tersebut",
                "type" => "soft",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],
            [
                "constraint" => "Terdapat guru mengajar lebih dari satu mata pelajaran",
                "type" => "soft",
                "max_teaching_hours" => null,
                "max_subject_hours" => null,
            ],

        ];

        foreach ($criteriaConstraints as $constraint) {
            CriteriaConstraint::updateOrCreate([
                "constraint" => $constraint['constraint'],
                "type" => $constraint['type'],
                "max_teaching_hours" => $constraint['max_teaching_hours'],
                "max_subject_hours" => $constraint['max_subject_hours'],
            ], $constraint);
        }
    }
}
