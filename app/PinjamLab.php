<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PinjamLab;

class PinjamLab extends Model
{
    public $timestamps= false;

    protected $table = "pinjamlab";

    protected $primaryKey = 'id_pinjam';

    protected $fillable = [
        'jam_pinjam', 'tanggal_pinjam', 'nama_pinjam', 'judul_pinjam', 'keterangan_pinjam', 'surat_pinjam', 'email_pinjam', 'asisten_jaga', 'id_lab'
    ];
}
