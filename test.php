<?php

// Inisialisasi parameter
$maxIterasi = 999999;
$tabuSize = 100;
$tabuList = [];
$kelas = ['Kelas 1', 'Kelas 2', 'Kelas 3'];
$mapel = ['Matematika', 'Bahasa Indonesia', 'Biologi', 'Kimia', 'Fisika', 'Sejarah'];
$jamPelajaran = 5; // Misalnya, 5 jam pelajaran per hari

// Fungsi untuk membuat solusi awal acak
function buatSolusiAwal($kelas, $mapel, $jamPelajaran) {
    $solusi = [];
    foreach ($kelas as $k) {
        foreach ($mapel as $m) {
            $solusi[$k][$m] = rand(1, $jamPelajaran);
        }
    }
    return $solusi;
}

// Fungsi untuk mengevaluasi solusi
function evaluasiSolusi($solusi) {
    $score = 0;
    foreach ($solusi as $kelas1 => $jadwal1) {
        foreach ($solusi as $kelas2 => $jadwal2) {
            if ($kelas1 != $kelas2) {
                foreach ($jadwal1 as $mapel => $jam) {
                    if (isset($jadwal2[$mapel]) && $jadwal2[$mapel] == $jam) {
                        $score++;
                    }
                }
            }
        }
    }
    return $score;
}

// Fungsi untuk membuat tetangga solusi
function buatTetangga($solusi, $jamPelajaran) {
    $kelas = array_keys($solusi);
    $mapel = array_keys($solusi[$kelas[0]]);
    $kelas1 = $kelas[array_rand($kelas)];
    $mapel1 = $mapel[array_rand($mapel)];
    $kelas2 = $kelas[array_rand($kelas)];
    $mapel2 = $mapel[array_rand($mapel)];

    $solusiBaru = $solusi;
    $temp = $solusiBaru[$kelas1][$mapel1];
    $solusiBaru[$kelas1][$mapel1] = rand(1, $jamPelajaran);
    $solusiBaru[$kelas2][$mapel2] = $temp;

    return $solusiBaru;
}

// Inisialisasi solusi awal
$solusiSaatIni = buatSolusiAwal($kelas, $mapel, $jamPelajaran);
$solusiTerbaik = $solusiSaatIni;
$bestScore = evaluasiSolusi($solusiTerbaik);

// Iterasi Tabu Search
for ($iterasi = 0; $iterasi < $maxIterasi; $iterasi++) {
    $tetanggaTerbaik = null;
    $bestNeighborScore = PHP_INT_MAX;

    for ($i = 0; $i < 10; $i++) {
        $tetangga = buatTetangga($solusiSaatIni, $jamPelajaran);
        $score = evaluasiSolusi($tetangga);

        if (!in_array($tetangga, $tabuList) && $score < $bestNeighborScore) {
            $tetanggaTerbaik = $tetangga;
            $bestNeighborScore = $score;
        }
    }

    if ($tetanggaTerbaik !== null) {
        $solusiSaatIni = $tetanggaTerbaik;
        array_push($tabuList, $solusiSaatIni);

        if (count($tabuList) > $tabuSize) {
            array_shift($tabuList);
        }

        if ($bestNeighborScore < $bestScore) {
            $solusiTerbaik = $solusiSaatIni;
            $bestScore = $bestNeighborScore;
        }
    }

}

echo "Solusi terbaik:\n";
print_r($solusiTerbaik);

?>
