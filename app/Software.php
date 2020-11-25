<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Software;

class Software extends Model
{
    public $timestamps= false;

    protected $table = "software";

    protected $primaryKey = 'id_software';

    protected $fillable = [
        'nama_software',
    ];
}
