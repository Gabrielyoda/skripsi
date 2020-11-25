<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jadwal;
use App\Http\Controllers\Controller;

class ApiJadwalController extends Controller
{

    //ini untuk get data jadwal semua
    public function dataall()
    {
        $jadwal = auth()->user()->jadwal;
        $jadwal = Jadwal::all();
        
        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }
}
