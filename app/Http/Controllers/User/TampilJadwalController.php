<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\TahunAjaran;
use App\Semester;

class TampilJadwalController extends Controller
{
    function index(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $hari_ini       = $this->cekhari();
        $tanggal_ini    = $this->cektanggal();
                      
        date_default_timezone_set('asia/jakarta');
        $jamsekarang    = date("H:i");

        $listjam    = array('06:40', '07:30', '08:25', '09:15', '10:10', '11:05', '12:00', '12:55', '13:50', '14:45', '15:40', '16:35', '17:30');

        for($i=0; $i<count($listjam); $i++)
        {
            if($jamsekarang >= $listjam[$i])
            {
                $jamarray    = array('07:10', '08:00', '08:55', '09:45', '10:40', '11:35', '12:30', '13:25', '14:20', '15:15', '16:10', '17:05', '18:00');

                $jam = $jamarray[$i];
            }
        }

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=', $hari_ini)
                    ->where(\DB::raw('substr(jam_ajar, 1, 5)'), '<=', $jam)
                    ->where(\DB::raw('substr(jam_ajar, 9)'), '>=', $jam)
                    ->orderBy('matakuliah.nama_mtk')
                    ->get();
                    
        return view('User\tampiljadwal')
        ->with('join', $join)
        ->with('hari_ini', $hari_ini)
        ->with('tanggal_ini', $tanggal_ini)
        ->with('title', 'Tampil');
    }

    function cekhari()
    {
        $hari = date("D");
     
        switch($hari){
            case 'Mon':$hari_ini = "Senin";break;
            case 'Tue':$hari_ini = "Selasa";break;
            case 'Wed':$hari_ini = "Rabu"; break;
            case 'Thu':$hari_ini = "Kamis";break;
            case 'Fri':$hari_ini = "Jumat";break;
            case 'Sat':$hari_ini = "Sabtu";break;
            case 'Sun':$hari_ini = "Minggu";break;

            default:$hari_ini = "Tidak diketahui";break;
        }
     
        return $hari_ini;
    }

    function cektanggal()
    {
        $tanggal = date('Y-m-d');

        $bulan = array (1 =>'Januari',2 =>'Februari',3 =>'Maret',4 =>'April',5 =>'Mei',6 =>'Juni',7 =>'Juli',8 =>'Agustus',9 =>'September',10 =>'Oktober',11 =>'November',12 =>'Desember');
        
        $pecah = explode('-', $tanggal);
        
        return $pecah[2].' '.$bulan[(int)$pecah[1]].' '. $pecah[0];
    }
}
