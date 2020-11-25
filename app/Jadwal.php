<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jadwal;

class Jadwal extends Model
{
    public $timestamps= false;
       
    protected $table = "jadwal";

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'semester', 'tahun_ajaran', 'kelompok', 'id_dosen', 'id_mtk', 'id_lab', 'hari', 'jam_ajar',
    ];
}
