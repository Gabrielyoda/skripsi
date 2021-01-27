<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\TahunAjaran;
use App\Semester;
use App\Lab;
use App\PinjamLab;
use App\Software;
use App\Spesifikasi;

class PinjamLabUserController extends Controller
{
    function index(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();
        
        return view('User\pinjamlab')
        ->with('title', 'PinjamLab');
    }

    function prosestambah(Request $request)
    {
        
        if($request->hasFile('surat'))
        {
            $nama           = $request->get('nama');
            $judul          = $request->get('judul');
            $keterangan     = $request->get('keterangan');
            $surat          = $request->file('surat');
            $tanggal        = $request->get('tanggal');
            $jamMulai       = $request->get('jamMulai');
            $jamSelesai     = $request->get('jamSelesai');
            $ruangLab       = $request->get('lab');
            $email          = $request->get('email');

            $namafilelama   = $surat -> getClientOriginalName();
            $namafile       = time().'_'.$namafilelama;
            $tempatsimpan   = public_path('/surat');

            $upload         = $surat -> move($tempatsimpan, $namafile);
            if($upload)
            {
                $pinjam  =  new PinjamLab();
                $pinjam  -> jam_pinjam          = $jamMulai.' - '.$jamSelesai;
                $pinjam  -> tanggal_pinjam      = $this->caritanggal($tanggal);
                $pinjam  -> nama_pinjam         = $nama;
                $pinjam  -> judul_pinjam        = $judul;
                $pinjam  -> keterangan_pinjam   = $keterangan;
                $pinjam  -> surat_pinjam        = $namafile;
                $pinjam  -> email_pinjam        = $email;
                $pinjam  -> id_lab              = $ruangLab;

                if($request->get('asisten') == "ya") {
                    $pinjam  -> asisten_jaga    = $request->get('asisten_jaga');
                }
                else {
                    $pinjam  -> asisten_jaga    = "0";
                }
                    
                if($pinjam->save())
                {
                    alert()->html('Berhasil Menambah Data!', 'Peminjaman Lab a.n. <strong>'.$nama.'</strong><br> pada tanggal <strong>'.$tanggal.'</strong> Berhasil Dibuat.', 'success')->autoClose(10000);
                    return redirect('/home');
                }
            }
            else
            {
                alert()->html('Gagal Menambah Data!', 'Mohon periksa kembali kesesuaian inputan Anda.', 'error')->autoClose(10000);
                return redirect('/peminjamanlab');
            }
        }
        else
        {
            alert()->html('Gagal Menambah Data!', 'Mohon periksa kembali kesesuaian inputan <strong>file Surat Peminjaman</strong> Anda.', 'error')->autoClose(10000);
            return redirect('/peminjamanlab');
        }
    }

    function getDataSoftware()
    {
        $software  = Software::all();
        
        return response()->json(array('software' => $software));
    }

    function getDataLab(Request $request)
    {
        $id         = $request->get('id');

        $ruangLab   = Lab::find($id);
        
        return response()->json(array('ruangLab' => $ruangLab));
    }

    function getDataSpesifikasi(Request $request)
    {
        $software       = $request->get('software');
        $jamAwal        = $request->get('jamAwal');
        $jamAkhir       = $request->get('jamAkhir');
        $tanggalPinjam  = $this->caritanggal($request->get('tanggalPinjam'));
        $hariPinjam     = $this->carihari($tanggalPinjam);

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $spesifikasi    = DB::table('spesifikasi')
                                    ->join('lab', 'spesifikasi.id_lab','=','lab.id_lab')
                                    ->select('lab.id_lab', DB::raw('COUNT(*) AS jumlah'))
                                    ->whereIn('spesifikasi.id_software', $software)
                                    ->whereNotIn('lab.id_lab', function ($query1) use($jamAwal,$jamAkhir,$hariPinjam,$tahun,$semester) {
                                        $query1     ->select(DB::raw('id_lab'))
                                                    ->from('jadwal')
                                                    ->whereRaw(DB::raw("(('$jamAwal' >= SUBSTRING(jam_ajar, 1, 5) AND '$jamAkhir' <= SUBSTRING(jam_ajar, 9, 5)) OR
                                                                    ('$jamAwal' BETWEEN SUBSTRING(jam_ajar, 1, 5) AND SUBSTRING(jam_ajar, 9, 5) AND '$jamAkhir' >= SUBSTRING(jam_ajar, 9, 5)) OR
                                                                    ('$jamAkhir' BETWEEN SUBSTRING(jam_ajar, 1, 5) AND SUBSTRING(jam_ajar, 9, 5) AND '$jamAwal' <= SUBSTRING(jam_ajar, 1, 5)) OR
                                                                    (SUBSTRING(jam_ajar, 1, 5) BETWEEN '$jamAwal' AND '$jamAkhir') AND ( SUBSTRING(jam_ajar, 9, 5)BETWEEN '$jamAwal' AND '$jamAkhir'))
                                                                    AND hari = '$hariPinjam' AND tahunajaran = '$tahun->tahunajaran' AND semester = '$semester->semester' GROUP BY id_lab"));
                                    })
                                    ->whereNotIn('lab.id_lab', function ($query2) use($jamAwal,$jamAkhir,$tanggalPinjam,$tahun,$semester) {
                                        $query2     ->select(DB::raw('kuliahpengganti.id_lab'))
                                                    ->from('jadwal')
                                                    ->join('kuliahpengganti', 'jadwal.id_jadwal','=','kuliahpengganti.id_jadwal')
                                                    ->whereRaw(DB::raw("(('$jamAwal' >= SUBSTRING(jam_pengganti, 1, 5) AND '$jamAkhir' <= SUBSTRING(jam_pengganti, 9, 5)) OR
                                                                    ('$jamAwal' BETWEEN SUBSTRING(jam_pengganti, 1, 5) AND SUBSTRING(jam_pengganti, 9, 5) AND '$jamAkhir' >= SUBSTRING(jam_pengganti, 9, 5)) OR
                                                                    ('$jamAkhir' BETWEEN SUBSTRING(jam_pengganti, 1, 5) AND SUBSTRING(jam_pengganti, 9, 5) AND '$jamAwal' <= SUBSTRING(jam_pengganti, 1, 5)) OR
                                                                    (SUBSTRING(jam_pengganti, 1, 5) BETWEEN '$jamAwal' AND '$jamAkhir') AND ( SUBSTRING(jam_pengganti, 9, 5)BETWEEN '$jamAwal' AND '$jamAkhir'))
                                                                    AND tanggal_pengganti = '$tanggalPinjam' AND tahunajaran = '$tahun->tahunajaran' AND semester = '$semester->semester' GROUP BY id_lab"));
                                    })
                                    ->whereNotIn('lab.id_lab', function ($query3) use($jamAwal,$jamAkhir,$tanggalPinjam) {
                                        $query3     ->select(DB::raw('id_lab'))
                                                    ->from('pinjamlab')
                                                    ->whereRaw(DB::raw("(('$jamAwal' >= SUBSTRING(jam_pinjam, 1, 5) AND '$jamAkhir' <= SUBSTRING(jam_pinjam, 9, 5)) OR
                                                                    ('$jamAwal' BETWEEN SUBSTRING(jam_pinjam, 1, 5) AND SUBSTRING(jam_pinjam, 9, 5) AND '$jamAkhir' >= SUBSTRING(jam_pinjam, 9, 5)) OR
                                                                    ('$jamAkhir' BETWEEN SUBSTRING(jam_pinjam, 1, 5) AND SUBSTRING(jam_pinjam, 9, 5) AND '$jamAwal' <= SUBSTRING(jam_pinjam, 1, 5)) OR
                                                                    (SUBSTRING(jam_pinjam, 1, 5) BETWEEN '$jamAwal' AND '$jamAkhir') AND ( SUBSTRING(jam_pinjam, 9, 5)BETWEEN '$jamAwal' AND '$jamAkhir'))
                                                                    AND tanggal_pinjam = '$tanggalPinjam' GROUP BY id_lab"));
                                    })
                                    ->groupby('lab.id_lab')
                                    ->having('jumlah', '=', count($software))
                                    ->get();

        $getLab = array();
        foreach($spesifikasi as $spek) {

            $getLab[]         = Lab::where('id_lab','=',$spek->id_lab)->first();
        }

        $listlab  = Lab::all();

        return response()->json ( array (
                                            "lab" => $getLab,
                                            "listlab" => $listlab,
                                        )
                                );
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
