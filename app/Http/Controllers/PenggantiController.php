<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Jadwal;
use App\Matakuliah;
use App\Dosen;
use App\Lab;
use App\User;
use App\KuliahPengganti;
use Alert;


class PenggantiController extends Controller
{
    function index(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $join   = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('kuliahpengganti.id_kp','jadwal.kelompok','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.username_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                    ->where('jadwal.semester','=',$request->session()->get('semester'))
                    ->get();

        return view('penggantiadmin')
        ->with('join', $join)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Kelas Pengganti');
    }

    function tambah(Request $request)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $matkul = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->select('matakuliah.id_mtk','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk')
                    ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                    ->where('jadwal.semester','=',$request->session()->get('semester'))
                    ->groupBy('matakuliah.kd_mtk')
                    ->get();

        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return view('tambahkelaspengganti')
        ->with('matkul', $matkul)
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Kelas Pengganti');
    }

    function prosestambah(Request $request)
    {
        $mtk        = $request->get('namaMatkul');
        $dosen      = $request->get('namaDosen');
        $kelompok   = strtoupper($request->get('kelompok'));
        $lab        = $request->get('namaLab');
        $tanggalkp  = $request->get('tanggalKP');
        $jamAjar    = $request->get('jamAjar');

        $tanggal    = $this->caritanggal($tanggalkp);
        $hari       = $this->carihari($tanggal);
    
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);
        
        $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $lab)
                                                        ->where('hari', $hari)
                                                        ->where('semester', $request->session()->get('semester'))
                                                        ->where('tahunajaran', $request->session()->get('tahunajaran'))
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
                            ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                            ->where('jadwal.semester','=',$request->session()->get('semester'))
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
        
        if($cek == 0)
        {
            $jadwal = Jadwal::select('id_jadwal')
                            ->where('kelompok','=', $kelompok)
                            ->where('id_dosen', $dosen)
                            ->where('id_mtk', $mtk)
                            ->where('semester', $request->session()->get('semester'))
                            ->where('tahunajaran', $request->session()->get('tahunajaran'))
                            ->first();

            $kp    = new KuliahPengganti();
            
            $kp     -> jam_Pengganti        = $jamAjar;
            $kp     -> tanggal_Pengganti    = $tanggal;
            $kp     -> id_lab               = $lab;
            $kp     -> id_jadwal            = $jadwal -> id_jadwal;
            
           if($kp->save()){
            $nama_mtk   = Matakuliah::select('nama_mtk')->where('id_mtk','=',$mtk)->first();
            
            alert()->html('Berhasil Menambah Data!', 'Kuliah Pengganti <strong>'.$nama_mtk->nama_mtk.'</strong><br> pada tanggal <strong>'.$tanggalkp.'</strong> Berhasil Dibuat.', 'success')->autoClose(10000);
            return redirect('/admin/kelaspengganti');
           } 

           
        }
        else
        {
            alert()->html('Gagal Menambah Data!', 'Waktu atau Ruang Lab Kuliah Pengganti bentrok.', 'error')->autoClose(10000);
            return redirect('/admin/kelaspengganti/tambah');
        }
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $kp     = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->select('kuliahpengganti.id_kp','jadwal.kelompok','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.id_mtk','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.id_dosen','dosen.username_dosen','dosen.nama_dosen','lab.id_lab','lab.nama_lab','lab.kapasitas_lab')
                    ->where('kuliahpengganti.id_kp','=',$id)
                    ->first();

        $tanggal_kp = KuliahPengganti::select('tanggal_pengganti')->where('id_kp', $id)->first();
        $tanggal    = $this->cektanggal($tanggal_kp['tanggal_pengganti']);

        $matkul = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->select('matakuliah.id_mtk','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk')
                    ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                    ->where('jadwal.semester','=',$request->session()->get('semester'))
                    ->groupBy('matakuliah.kd_mtk')
                    ->get();

        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        $jumlahSks  = DB::table('jadwal')
                        ->join('kuliahpengganti', 'jadwal.id_jadwal','=','kuliahpengganti.id_jadwal')
                        ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                        ->select('matakuliah.sks_mtk')
                        ->where('kuliahpengganti.id_kp','=',$id)
                        ->first();

        $sks1 = array('07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50');  
        if($jumlahSks -> sks_mtk == 1) 
        {
            $jamAjar = $sks1;
        }
        else
        {
            $sks2 = array('07:10 - 08:50', '08:00 - 09:40', '08:55 - 10:35', '09:45 - 11:30', '10:40 - 12:25', '11:35 - 13:20', '12:30 - 14:15', '13:25 - 15:10', '14:20 - 16:05', '15:15 - 17:00', '16:10 - 17:55', '17:05 - 18:50');   
            if($jumlahSks -> sks_mtk == 2)
            {
                $jamAjar = $sks2;
            }
            else
            {
                $sks3 = array('07:10 - 09:40', '08:00 - 10:35', '08:55 - 11:30', '09:45 - 12:25', '10:40 - 13:20', '11:35 - 14:15', '12:30 - 15:10', '13:25 - 16:05', '14:20 - 17:00', '15:15 - 17:55', '16:10 - 18:50');
                if($jumlahSks -> sks_mtk == 3)
                {
                    $jamAjar = $sks3;
                }
                else
                {
                    $jamAjar  = 0;
                }
            }
        }

        return view('ubahkelaspengganti')
        ->with('kp', $kp)
        ->with('jamAjar', $jamAjar)
        ->with('tanggal', $tanggal)
        ->with('matkul', $matkul)
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Kelas Pengganti');
    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        
        $mtk        = $request->get('namaMatkul');
        $dosen      = $request->get('namaDosen');
        $kelompok   = $request->get('kelompok');
        $lab        = $request->get('namaLab');
        $tanggalkp  = $request->get('tanggalKP');
        $jamAjar    = $request->get('jamAjar');

        $tanggal    = $this->caritanggal($tanggalkp);
        $hari       = $this->carihari($tanggal);
    
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);
        
        $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $lab)
                                                        ->where('hari', $hari)
                                                        ->where('semester', $request->session()->get('semester'))
                                                        ->where('tahunajaran', $request->session()->get('tahunajaran'))
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
                            ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                            ->where('jadwal.semester','=',$request->session()->get('semester'))
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
        
        if($cek == 0)
        {
            $jadwal = Jadwal::select('id_jadwal')
                            ->where('kelompok','=', $kelompok)
                            ->where('id_dosen', $dosen)
                            ->where('id_mtk', $mtk)
                            ->where('semester', $request->session()->get('semester'))
                            ->where('tahunajaran', $request->session()->get('tahunajaran'))
                            ->first();

            $kp    = KuliahPengganti::find($id);

            $kp     -> jam_Pengganti        = $jamAjar;
            $kp     -> tanggal_Pengganti    = $tanggal;
            $kp     -> id_lab               = $lab;
            $kp     -> id_jadwal            = $jadwal->id_jadwal;

            if($kp->save())
            {
                return redirect('/admin/kelaspengganti');
            }
        }
        else
        {
            return redirect('/admin/kelaspengganti/ubah/'.$id);
        }
    }

    function hapus(Request $request, $id)
    {
        $kp    = KuliahPengganti::find($id);

        if($kp -> delete())
        {
            alert()->html('Berhasil Hapus Data', 'Berhasil Menghapus Data Kuliah Pengganti', 'success')->autoClose(10000);
            return redirect('/admin/kelaspengganti');
        }
    }

    function cektanggal($tanggal)
    {
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
}
