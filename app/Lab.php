<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lab;

class Lab extends Model
{
    public $timestamps= false;

    protected $table = "lab";

    protected $primaryKey = 'id_lab';

    protected $fillable = [
        'nama_lab', 'kapasitas_lab',
    ];
}
