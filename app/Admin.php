<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Model
{
    protected $primaryKey = 'nim_admin';

    protected $fillable = [
        'nim_admin', 'nama_admin', 'password_admin', 'telepon_admin', 'email_admin', 'jabatan_admin', 'foto_admin'
    ];

    protected $time_stamp = false;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
