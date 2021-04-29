<?php

namespace App\Imports;

use App\Jadwal;
use Maatwebsite\Excel\Concerns\ToModel;

class JadwalImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Jadwal([
            'semester' => $row[1],
            'jam_ajar' => $row[2], 
            'tahunajaran' => $row[3],
            'kelompok' => $row[4],
            'id_user' => $row[5], 
            'id_mtk' => $row[6],
            'id_lab' => $row[7],
            'hari' => $row[8], 
        ]);
    }
}
