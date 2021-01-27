<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Jadwal;
use App\Matakuliah;
use App\Dosen;
use App\Lab;
use App\User;

class JadwalController extends Controller
{
    function index(Request $request)
    {
        // if($request->session()->get('jabatan') != 'spv') {}
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.id_jadwal','jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','users.id_user','users.nama','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                    ->where('jadwal.semester','=',$request->session()->get('semester'))
                    ->get();

        return view('jadwaladmin')
        ->with('join', $join)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Jadwal');
    }

    function tambah(Request $request)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $matkul = Matakuliah::select('*')->orderBy('nama_mtk')->get();
        $dosen  = User::select('*')->orderBy('nama')->where('jabatan','=', 'Dosen')->get();
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return view('tambahjadwal')
        ->with('matkul', $matkul)
        ->with('dosen', $dosen)
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Jadwal');
    }

    function prosestambah(Request $request)
    {
        $mtk        = $request->get('namaMatkul');
        $dosen      = $request->get('namaDosen');
        $kelompok   = strtoupper($request->get('kelompok'));
        $lab        = $request->get('namaLab');
        $hari       = $request->get('hari');
        $jamAjar    = $request->get('jamAjar');

        $cekwaktu        = Jadwal::select('jam_ajar')   ->where('id_lab', $lab)
                                                        ->where('hari', $hari)
                                                        ->where('semester', $request->session()->get('semester'))
                                                        ->where('tahunajaran', $request->session()->get('tahunajaran'))
                                                        ->get();
        
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);
        
        foreach($cekwaktu as $cekwaktus) 
        {
            $jamMasuk   = substr($cekwaktus -> jam_ajar, 0, -8);
            $jamKeluar  = substr($cekwaktus -> jam_ajar, -5);

            if($jamKeluar >= $jamAjarMasuk && $jamMasuk <= $jamAjarKeluar) 
            {
                $cek = 1;
                break;
            }
        }
        
        if($cek == 0)
        {
            $jadwal    = new Jadwal();
            
            $jadwal    -> semester      = $request->session()->get('semester');
            $jadwal    -> tahunajaran   = $request->session()->get('tahunajaran');
            $jadwal    -> kelompok      = $kelompok;
            $jadwal    -> id_user      = $dosen;
            $jadwal    -> id_mtk        = $mtk;
            $jadwal    -> id_lab        = $lab;
            $jadwal    -> hari          = $hari;
            $jadwal    -> jam_ajar      = $jamAjar;
            
            $jadwal->save();

            alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Jadwal', 'success')->autoClose(10000);
            return redirect('/admin/jadwal');
        }
        else
        {
            alert()->html('Gagal Tambah Data', 'Gagal menambahkan Data Jadwal Silahkan Cek Kembali Jadwal', 'error')->autoClose(10000);
            return redirect('/admin/jadwal/tambah');
        }
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $jadwal  = Jadwal::find($id);

        $matkul = Matakuliah::select('*')->orderBy('nama_mtk')->get();
        $dosen  = User::select('*')->orderBy('nama')->where('jabatan','=', 'Dosen')->get();
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        $jumlahSks = Matakuliah::select("sks_mtk")->where('id_mtk','=',$jadwal->id_mtk)->first();

        $sks1 = array('07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50');  
        if($jumlahSks ->sks_mtk == 1) 
        {
            $jamAjar = $sks1;
        }
        else
        {
            $sks2 = array('07:10 - 08:50', '08:00 - 09:40', '08:55 - 10:35', '09:45 - 11:30', '10:40 - 12:25', '11:35 - 13:20', '12:30 - 14:15', '13:25 - 15:10', '14:20 - 16:05', '15:15 - 17:00', '16:10 - 17:55', '17:05 - 18:50');   
            if($jumlahSks ->sks_mtk == 2)
            {
                $jamAjar = $sks2;
            }
            else
            {
                $sks3 = array('07:10 - 09:40', '08:00 - 10:35', '08:55 - 11:30', '09:45 - 12:25', '10:40 - 13:20', '11:35 - 14:15', '12:30 - 15:10', '13:25 - 16:05', '14:20 - 17:00', '15:15 - 17:55', '16:10 - 18:50');
                if($jumlahSks ->sks_mtk == 3)
                {
                    $jamAjar = $sks3;
                }
                else
                {
                    $jamAjar  = 0;
                }
            }
        }

        return view('ubahjadwal')
        ->with('jadwal', $jadwal)
        ->with('jamAjar', $jamAjar)
        ->with('matkul', $matkul)
        ->with('dosen', $dosen)
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Jadwal');
    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        
        $mtk        = $request->get('namaMatkul');
        $dosen      = $request->get('namaDosen');
        $kelompok   = $request->get('kelompok');
        $lab        = $request->get('namaLab');
        $hari       = $request->get('hari');
        $jamAjar    = $request->get('jamAjar');

        $jadwal    = Jadwal::find($id);
        
        $jadwal    -> kelompok      = $kelompok;
        $jadwal    -> id_user      = $dosen;
        $jadwal    -> id_mtk        = $mtk;
        $jadwal    -> id_lab        = $lab;
        $jadwal    -> hari          = $hari;
        $jadwal    -> jam_ajar      = $jamAjar;

        if($jadwal->save())
        { 
            alert()->html('Berhasil Ubah Data', 'Berhasil Mengubah Data Jadwal', 'success')->autoClose(10000);
            return redirect('/admin/jadwal');
        }
    }

    function hapus(Request $request, $id)
    {
        $jadwal    = Jadwal::find($id);

        if($jadwal -> delete())
        {
            alert()->html('Berhasil Menghapus Data', 'Berhasil Menghapus Data Jadwal', 'success')->autoClose(10000);
            return redirect('/admin/jadwal');
        }
    }

    function ceksks(Request $request)
    {   
        $id         = $request->get('idjadwal');

        $jumlahSks = Matakuliah::select("sks_mtk")->where('id_mtk','=',$id)->first();

        $sks1 = array('07:10 - 07:55', '08:00 - 08:50', '08:55 - 09:40', '09:45 - 10:35', '10:40 - 11:30', '11:35 - 12:25', '12:30 - 13:20', '13:25 - 14:15', '14:20 - 15:10', '15:15 - 16:05', '16:10 - 17:00', '17:05 - 17:55', '18:00 - 18:50');  
        if($jumlahSks ->sks_mtk == 1) 
        {
            return response()->json($sks1);
        }
        else
        {
            $sks2 = array('07:10 - 08:50', '08:00 - 09:40', '08:55 - 10:35', '09:45 - 11:30', '10:40 - 12:25', '11:35 - 13:20', '12:30 - 14:15', '13:25 - 15:10', '14:20 - 16:05', '15:15 - 17:00', '16:10 - 17:55', '17:05 - 18:50');   
            if($jumlahSks ->sks_mtk == 2)
            {
                return response()->json($sks2);
            }
            else
            {
                $sks3 = array('07:10 - 09:40', '08:00 - 10:35', '08:55 - 11:30', '09:45 - 12:25', '10:40 - 13:20', '11:35 - 14:15', '12:30 - 15:10', '13:25 - 16:05', '14:20 - 17:00', '15:15 - 17:55', '16:10 - 18:50');
                if($jumlahSks ->sks_mtk == 3)
                {
                    return response()->json($sks3);
                }
                else
                {
                    return response()->json(0);
                }
            }
        }
    }
}
