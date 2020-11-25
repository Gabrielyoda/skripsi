<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Spesifikasi;

class Spesifikasi extends Model
{
    public $timestamps= false;

    protected $table = "spesifikasi";

    protected $primaryKey = 'id_spek';

    protected $fillable = [
        'id_lab', 'id_software',
    ];
}
