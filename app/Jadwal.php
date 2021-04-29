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
        'semester', 'tahunajaran', 'kelompok', 'id_user', 'id_mtk', 'id_lab', 'hari', 'jam_ajar',
    ];
}
