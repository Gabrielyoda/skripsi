<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Semester;

class Semester extends Model
{
    public $timestamps= false;

    protected $table = "semester";

    protected $primaryKey = 'id_semester';

    protected $fillable = [
        'semester', 'status_semester'
    ];
}
