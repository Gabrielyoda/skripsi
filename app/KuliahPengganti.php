<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\KuliahPengganti;


class KuliahPengganti extends Model
{
    public $timestamps= false;

    protected $table = "kuliahpengganti";

    protected $primaryKey = 'id_kp';

    protected $fillable = [
        'jam_pengganti', 'tanggal_pengganti', 'id_lab', 'id_jadwal'
    ];
}
