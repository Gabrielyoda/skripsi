<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    public $timestamps= false;
    
    protected $table = "dosen";

    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'username', 'nama_dosen', 'password',
    ];
}
