<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TahunAjaran;

class TahunAjaran extends Model
{
    public $timestamps= false;

    protected $table = "tahunajaran";

    protected $primaryKey = 'id_tahunajaran';

    protected $fillable = [
        'tahunajaran', 'status_tahunajaran'
    ];
}
