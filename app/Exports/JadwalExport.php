<?php

namespace App\Exports;

use App\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;

class JadwalExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jadwal::all();
    }
}
