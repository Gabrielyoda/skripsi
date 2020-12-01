<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\TahunAjaran;
use App\Semester;
use App\Jadwal;
use App\Matakuliah;
use App\Dosen;
use App\Lab;
use App\KuliahPengganti;
use App\PinjamLab;

class JadwalUserController extends Controller
{
    function index(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $hari_ini       = $this->cekhari();
        $tanggal_ini    = $this->cektanggal();

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=',$hari_ini)
                    ->get();
        
        $joinKP = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('kuliahpengganti.id_kp','jadwal.kelompok','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('kuliahpengganti.tanggal_pengganti','=', date('Y-m-d'))
                    ->where('jadwal.tahunajaran','=', $tahun->tahunajaran)
                    ->where('jadwal.semester','=', $semester->semester)
                    ->get();

        $joinPinjam     = DB::table('pinjamlab')
                            ->join('lab', 'lab.id_lab','=','pinjamlab.id_lab')
                            ->select('pinjamlab.jam_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','lab.nama_lab')
                            ->where('pinjamlab.tanggal_pinjam','=', date('Y-m-d'))
                            ->get();

        $data   = array();

        foreach($joinPinjam as $joinPinjams) {
            $jamAwal    =    substr($joinPinjams->jam_pinjam, 0, -8);
            $jamAkhir   =    substr($joinPinjams->jam_pinjam, -5);

            $jamMasuk   = array('06:15', '07:10', '08:00', '08:55', '09:45', '10:40', '11:35', '12:30', '13:25', '14:20', '15:15', '16:10', '17:05');
            $jamKeluar  = array('07:55', '08:50', '09:40', '10:35', '11:30', '12:25', '13:20', '14:15', '15:10', '16:05', '17:01', '17:55', '18:50');

            for($i=0; $i<count($jamMasuk)-1; $i++) {
                if($jamAwal >= $jamMasuk[$i] && $jamAwal <= $jamMasuk[$i+1]) {
                    
                    if($jamMasuk[$i] == '06:15') {
                        $jamAwalHasil = '07:10';
                    }
                    else {
                        $jamAwalHasil = $jamMasuk[$i];
                    }

                    $x  = ($i-1);
                    if($x < 0) {
                        $x  = 0;
                    }
                }

                if($jamAkhir >= $jamKeluar[$i] && $jamAkhir <= $jamKeluar[$i+1]) {
                    $jamAkhirHasil  = $jamKeluar[$i+1];

                    $y  = ($i+2);
                }
            }

            $lamaPinjam     = $y - $x;

            $data[]     = array(
                "nama_pinjam"   => $joinPinjams->nama_pinjam,
                "jamAwal"       => $jamAwalHasil,
                "jamAkhir"      => $jamAkhirHasil,
                "jamAwalAsli"   => $jamAwal,
                "jamAkhirAsli"  => $jamAkhir,
                "lamaPinjam"    => $lamaPinjam,
                "judul_pinjam"  => $joinPinjams->judul_pinjam,
                "nama_lab"      => $joinPinjams->nama_lab,
            );
        }

        return view('User\homeall')
        ->with('join', $join)
        ->with('joinKP', $joinKP)
        ->with('joinPinjam', $data)
        ->with('hari_ini', $hari_ini)
        ->with('tanggal_ini', $tanggal_ini)
        ->with('title', 'Jadwal');
    }

    function index2(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $hari_ini       = $this->cekhari();
        $tanggal_ini    = $this->cektanggal();

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=',$hari_ini)
                    ->get();
        
        $joinKP = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('kuliahpengganti.id_kp','jadwal.kelompok','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('kuliahpengganti.tanggal_pengganti','=', date('Y-m-d'))
                    ->where('jadwal.tahunajaran','=', $tahun->tahunajaran)
                    ->where('jadwal.semester','=', $semester->semester)
                    ->get();

        $joinPinjam     = DB::table('pinjamlab')
                            ->join('lab', 'lab.id_lab','=','pinjamlab.id_lab')
                            ->select('pinjamlab.jam_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','lab.nama_lab')
                            ->where('pinjamlab.tanggal_pinjam','=', date('Y-m-d'))
                            ->get();

        $data   = array();

        foreach($joinPinjam as $joinPinjams) {
            $jamAwal    =    substr($joinPinjams->jam_pinjam, 0, -8);
            $jamAkhir   =    substr($joinPinjams->jam_pinjam, -5);

            $jamMasuk   = array('06:15', '07:10', '08:00', '08:55', '09:45', '10:40', '11:35', '12:30', '13:25', '14:20', '15:15', '16:10', '17:05');
            $jamKeluar  = array('07:55', '08:50', '09:40', '10:35', '11:30', '12:25', '13:20', '14:15', '15:10', '16:05', '17:01', '17:55', '18:50');

            for($i=0; $i<count($jamMasuk)-1; $i++) {
                if($jamAwal >= $jamMasuk[$i] && $jamAwal <= $jamMasuk[$i+1]) {
                    
                    if($jamMasuk[$i] == '06:15') {
                        $jamAwalHasil = '07:10';
                    }
                    else {
                        $jamAwalHasil = $jamMasuk[$i];
                    }

                    $x  = ($i-1);
                    if($x < 0) {
                        $x  = 0;
                    }
                }

                if($jamAkhir >= $jamKeluar[$i] && $jamAkhir <= $jamKeluar[$i+1]) {
                    $jamAkhirHasil  = $jamKeluar[$i+1];

                    $y  = ($i+2);
                }
            }

            $lamaPinjam     = $y - $x;

            $data[]     = array(
                "nama_pinjam"   => $joinPinjams->nama_pinjam,
                "jamAwal"       => $jamAwalHasil,
                "jamAkhir"      => $jamAkhirHasil,
                "jamAwalAsli"   => $jamAwal,
                "jamAkhirAsli"  => $jamAkhir,
                "lamaPinjam"    => $lamaPinjam,
                "judul_pinjam"  => $joinPinjams->judul_pinjam,
                "nama_lab"      => $joinPinjams->nama_lab,
            );
        }

        return view('User\homeuser')
        ->with('join', $join)
        ->with('joinKP', $joinKP)
        ->with('joinPinjam', $data)
        ->with('hari_ini', $hari_ini)
        ->with('tanggal_ini', $tanggal_ini)
        ->with('title', 'Jadwal');
    }

    function gantiwaktu(Request $request) 
    {
        $waktu  = $request->get('waktu');
        $hari   = $request->get('hari');

        $tanggal_ini    = $this->caritanggal($waktu);
        
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=',$hari)
                    ->get();

        $joinKP = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('kuliahpengganti.id_kp','jadwal.kelompok','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('kuliahpengganti.tanggal_pengganti','=', $tanggal_ini)
                    ->where('jadwal.tahunajaran','=', $tahun->tahunajaran)
                    ->where('jadwal.semester','=', $semester->semester)
                    ->get();

        $joinPinjam = DB::table('pinjamlab')
                        ->join('lab', 'lab.id_lab','=','pinjamlab.id_lab')
                        ->select('pinjamlab.jam_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','lab.nama_lab')
                        ->where('pinjamlab.tanggal_pinjam','=', $tanggal_ini)
                        ->get();

        $data   = array();
        $jamMasuk   = array('06:15', '07:10', '08:00', '08:55', '09:45', '10:40', '11:35', '12:30', '13:25', '14:20', '15:15', '16:10', '17:05');
        $jamKeluar  = array('07:55', '08:50', '09:40', '10:35', '11:30', '12:25', '13:20', '14:15', '15:10', '16:05', '17:01', '17:55', '18:50');

        foreach($joinPinjam as $joinPinjams) {
            $jamAwal    =    substr($joinPinjams->jam_pinjam, 0, -8);
            $jamAkhir   =    substr($joinPinjams->jam_pinjam, -5);

            for($i=0; $i<count($jamMasuk)-1; $i++) {
                if($jamAwal >= $jamMasuk[$i] && $jamAwal <= $jamMasuk[$i+1]) {
                    
                    if($jamMasuk[$i] == '06:15') {
                        $jamAwalHasil = '07:10';
                    }
                    else {
                        $jamAwalHasil = $jamMasuk[$i];
                    }

                    $x  = ($i-1);
                    if($x < 0) {
                        $x  = 0;
                    }
                }

                if($jamAkhir >= $jamKeluar[$i] && $jamAkhir <= $jamKeluar[$i+1]) {
                    $jamAkhirHasil  = $jamKeluar[$i+1];

                    $y  = ($i+2);
                }
            }

            $lamaPinjam     = $y - $x;

            $data[]     = array(
                "nama_pinjam"   => $joinPinjams->nama_pinjam,
                "jamAwal"       => $jamAwalHasil,
                "jamAkhir"      => $jamAkhirHasil,
                "jamAwalAsli"   => $jamAwal,
                "jamAkhirAsli"  => $jamAkhir,
                "lamaPinjam"    => $lamaPinjam,
                "judul_pinjam"  => $joinPinjams->judul_pinjam,
                "nama_lab"      => $joinPinjams->nama_lab,
            );
        }

        return response()->json(array(
                                        'join'          => $join,
                                        'joinKP'        => $joinKP,
                                        'joinPinjam'    => $data,
                                    ));
    }

    function kelaspengganti(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $matkul = Matakuliah::all();
        $dosen  = Dosen::all();
        
        return view('User\kelaspengganti')
        ->with('matkul', $matkul)
        ->with('dosen', $dosen)
        ->with('title', 'KP');
    }

    function prosestambah(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $mtk        = $request->get('namaMatkul');
        $dosen      = $request->get('namaDosen');
        $kelompok   = strtoupper($request->get('kelompok'));
        $tanggalkp  = $request->get('tanggalKP');
        $jamAjar    = $request->get('jamAjar');
        $cariLab    = Lab::select('id_lab')->where('nama_lab', $request->get('ruangLab'))->first();
        $lab        = $cariLab->id_lab;

        $tanggal    = $this->caritanggal($tanggalkp);
        $hari       = $this->carihari($tanggal);
        
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);
        
        $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $lab)
                                                        ->where('hari', $hari)
                                                        ->where('tahunajaran', $tahun->tahunajaran)
                                                        ->where('semester', $semester->semester)
                                                        ->get();
        
        foreach($cekwaktu as $cekwaktus) 
        {
            $jamMasuk   = substr($cekwaktus -> jam_ajar, 0, -8);
            $jamKeluar  = substr($cekwaktus -> jam_ajar, -5);

            if($jamKeluar >= $jamAjarMasuk && $jamMasuk <= $jamAjarKeluar) 
            {
                $cek = 1;
            }
        }
        
        $cektanggal     = DB::table('jadwal')
                            ->join('kuliahpengganti', 'jadwal.id_jadwal','=','kuliahpengganti.id_jadwal')
                            ->select('kuliahpengganti.jam_pengganti')
                            ->where('kuliahpengganti.id_lab', '=', $lab)
                            ->where('kuliahpengganti.tanggal_pengganti', '=', $tanggal)
                            ->where('tahunajaran', $tahun->tahunajaran)
                            ->where('semester', $semester->semester)
                            ->get();
        
        foreach($cektanggal as $cektanggals) 
        {
            $jamMasuk   = substr($cektanggals -> jam_pengganti, 0, -8);
            $jamKeluar  = substr($cektanggals -> jam_pengganti, -5);
                                                            
            if($jamKeluar >= $jamAjarMasuk && $jamMasuk <= $jamAjarKeluar) 
            {
                $cek = 1;
            }
        }

        $cekpinjam      = PinjamLab::select('jam_pinjam')->where('tanggal_pinjam','=',$tanggal)->where('id_lab','=',$lab)->get();
        
        foreach($cekpinjam as $cekpinjams) 
        {
            $jamMasuk   = substr($cekpinjams -> jam_pinjam, 0, -8);
            $jamKeluar  = substr($cekpinjams -> jam_pinjam, -5);
                                                            
            if($jamKeluar >= $jamAjarMasuk && $jamMasuk <= $jamAjarKeluar) 
            {
                $cek = 1;
            }
        }

        if($cek == 0)
        {
            $jadwal = Jadwal::select('id_jadwal')
                            ->where('kelompok','=', $kelompok)
                            ->where('id_dosen', $dosen)
                            ->where('id_mtk', $mtk)
                            ->where('tahunajaran', $tahun->tahunajaran)
                            ->where('semester', $semester->semester)
                            ->first();

            $kp    = new KuliahPengganti();
            
            $kp     -> jam_Pengganti        = $jamAjar;
            $kp     -> tanggal_Pengganti    = $tanggal;
            $kp     -> id_lab               = $lab;
            $kp     -> id_jadwal            = $jadwal->id_jadwal;

        //    dd($kp);
            
            if($kp->save())
            {
                $nama_mtk   = Matakuliah::select('nama_mtk')->where('id_mtk','=',$mtk)->first();

                alert()->html('Berhasil Menambah Data!', 'Kuliah Pengganti <strong>'.$nama_mtk->nama_mtk.'</strong><br> pada tanggal <strong>'.$tanggalkp.'</strong> Berhasil Dibuat.', 'success')->autoClose(10000);
                return redirect('/homeuser');
            }
        }
        else
        {
            alert()->html('Gagal Menambah Data!', 'Waktu atau Ruang Lab Kuliah Pengganti bentrok.', 'error')->autoClose(10000);
            return redirect('/kuliahpengganti');
        }
    }

    function caridosen(Request $request)
    {   
        $id         = $request->get('idmtk');

        $dosen  = DB::table('jadwal')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('jadwal.id_dosen', 'dosen.username_dosen','dosen.nama_dosen')
                    ->where('jadwal.id_mtk','=',$id)
                    ->groupBy('jadwal.id_dosen')
                    ->get();

        $sks    = Matakuliah::select('sks_mtk')->where('id_mtk','=',$id)->first();

        return response()->json(array(
                'dosen'     => $dosen,
                'sks'       => $sks,
            ));
    }

    function carikelompok(Request $request)
    {   
        $idmtk      = $request->get('idmtk');
        $iddosen    = $request->get('iddosen');

        $kelompok  = DB::table('jadwal')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('jadwal.kelompok')
                    ->where('jadwal.id_mtk','=',$idmtk)
                    ->where('jadwal.id_dosen','=',$iddosen)
                    ->get();

        return response()->json($kelompok);
    }

    function carijamajar(Request $request)
    {
        $tanggalKP  = $request->get('tanggalKP');

        $tanggal    = $this->caritanggal($tanggalKP);
        $hari       = $this->carihari($tanggal);

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.hari','jadwal.jam_ajar','matakuliah.sks_mtk','lab.nama_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=',$hari)
                    ->get();

        $joinKP = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->select('kuliahpengganti.id_kp','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.sks_mtk','lab.nama_lab')
                    ->where('kuliahpengganti.tanggal_pengganti','=', $tanggal)
                    ->where('jadwal.tahunajaran','=', $tahun->tahunajaran)
                    ->where('jadwal.semester','=', $semester->semester)
                    ->get();

        $joinPinjam = DB::table('pinjamlab')
                        ->join('lab', 'lab.id_lab','=','pinjamlab.id_lab')
                        ->select('pinjamlab.jam_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','lab.nama_lab')
                        ->where('pinjamlab.tanggal_pinjam','=', $tanggal)
                        ->get();

        $data   = array();

        foreach($joinPinjam as $joinPinjams) {
            $jamAwal    =    substr($joinPinjams->jam_pinjam, 0, -8);
            $jamAkhir   =    substr($joinPinjams->jam_pinjam, -5);

            $jamMasuk   = array('06:15', '07:10', '08:00', '08:55', '09:45', '10:40', '11:35', '12:30', '13:25', '14:20', '15:15', '16:10', '17:05');
            $jamKeluar  = array('07:55', '08:50', '09:40', '10:35', '11:30', '12:25', '13:20', '14:15', '15:10', '16:05', '17:01', '17:55', '18:50');

            for($i=0; $i<count($jamMasuk)-1; $i++) {
                if($jamAwal >= $jamMasuk[$i] && $jamAwal <= $jamMasuk[$i+1]) {
                    
                    if($jamMasuk[$i] == '06:15') {
                        $jamAwalHasil = '07:10';
                    }
                    else {
                        $jamAwalHasil = $jamMasuk[$i];
                    }

                    $x  = ($i-1);
                    if($x < 0) {
                        $x  = 0;
                    }
                }

                if($jamAkhir >= $jamKeluar[$i] && $jamAkhir <= $jamKeluar[$i+1]) {
                    $jamAkhirHasil  = $jamKeluar[$i+1];

                    $y  = ($i+2);
                }
            }

            $lamaPinjam     = $y - $x;

            $data[]     = array(
                "nama_pinjam"   => $joinPinjams->nama_pinjam,
                "jamAwal"       => $jamAwalHasil,
                "jamAkhir"      => $jamAkhirHasil,
                "jamAwalAsli"   => $jamAwal,
                "jamAkhirAsli"  => $jamAkhir,
                "lamaPinjam"    => $lamaPinjam,
                "judul_pinjam"  => $joinPinjams->judul_pinjam,
                "nama_lab"      => $joinPinjams->nama_lab,
            );
        }

        return response()->json(array(
                                        'join'          => $join,
                                        'joinKP'        => $joinKP,
                                        'joinPinjam'    => $data,
                                    ));
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

    function carihari($tanggal)
    {
        $hari = date('D', strtotime($tanggal));
     
        switch($hari){
            case 'Mon':$hari_kp = "Senin";break;
            case 'Tue':$hari_kp = "Selasa";break;
            case 'Wed':$hari_kp = "Rabu"; break;
            case 'Thu':$hari_kp = "Kamis";break;
            case 'Fri':$hari_kp = "Jumat";break;
            case 'Sat':$hari_kp = "Sabtu";break;
            case 'Sun':$hari_kp = "Minggu";break;

            default:$hari_kp = "Tidak diketahui";break;
        }
     
        return $hari_kp;
    }

    function cektanggal()
    {
        $tanggal = date('Y-m-d');

        $bulan = array (1 =>'Januari',2 =>'Februari',3 =>'Maret',4 =>'April',5 =>'Mei',6 =>'Juni',7 =>'Juli',8 =>'Agustus',9 =>'September',10 =>'Oktober',11 =>'November',12 =>'Desember');
        
        $pecah = explode('-', $tanggal);
        
        return $pecah[2].' '.$bulan[(int)$pecah[1]].' '. $pecah[0];
    }

    function caritanggal($tanggal)
    {
        $tahun      = substr($tanggal, -4, 4);
        $bulan      = substr($tanggal, 3, -5);
        $tanggal    = substr($tanggal, 0, 2);

        switch($bulan){
            case 'Januari':$bulan_kp = "01";break;
            case 'Februari':$bulan_kp = "02";break;
            case 'Maret':$bulan_kp = "03"; break;
            case 'April':$bulan_kp = "04";break;
            case 'Mei':$bulan_kp = "05";break;
            case 'Juni':$bulan_kp = "06";break;
            case 'Juli':$bulan_kp = "07";break;
            case 'Agustus':$bulan_kp = "08";break;
            case 'September':$bulan_kp = "09";break;
            case 'Oktober':$bulan_kp = "10";break;
            case 'November':$bulan_kp = "11";break;
            case 'Desember':$bulan_kp = "12";break;

            default:$bulan_kp = "Tidak diketahui";break;
        }

        $tanggal_kp = $tahun.'-'.$bulan_kp.'-'.$tanggal;
        
        return $tanggal_kp;
    }
}
