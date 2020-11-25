<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Matakuliah;

class Matakuliah extends Model
{
    public $timestamps= false;

    protected $table = "matakuliah";

    protected $primaryKey = 'id_mtk';

    protected $fillable = [
        'kd_mtk', 'nama_mtk', 'sks_mtk',
    ];
}
