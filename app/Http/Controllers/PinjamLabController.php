<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Aes256\Prosesaes;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Jadwal;
use App\Matakuliah;
use App\Dosen;
use App\Lab;
use App\User;
use App\KuliahPengganti;
use App\PinjamLab;
use Alert;

class PinjamLabController extends Controller{
    function index(Request $request){
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $join   = DB::table('pinjamlab')
                    ->join('lab', 'pinjamlab.id_lab','=','lab.id_lab')
                    ->select('pinjamlab.id_pinjam','pinjamlab.jam_pinjam','pinjamlab.tanggal_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','pinjamlab.keterangan_pinjam','pinjamlab.email_pinjam','lab.nama_lab','lab.kapasitas_lab')
                    ->get();

                    for($i=0; $i<count($join); $i++) {
                        $join[$i]->nama_pinjam = $this->dekripsi($join[$i]->nama_pinjam);
                    }

        return view('pinjamlab')
        ->with('join', $join)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Pinjam Lab');
    }

    function tambah(Request $request)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;


        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return view('tambahpinjamlab')
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Pinjam Lab');
    }

    function prosestambah(Request $request)
    {
            $nama           = $request->get('nama');
            $judul          = $request->get('judul');
            $keterangan     = $request->get('keterangan');
            $tanggalPinjam  = $request->get('tanggal');
            $jamMulai       = $request->get('jamMulai');
            $jamSelesai     = $request->get('jamSelesai');
            $ruangLab       = $request->get('lab');
            $email          = $request->get('email');

           

            $tanggal    = $this->caritanggal($tanggalPinjam);
            $hari       = $this->carihari($tanggal);

            $cek = 0;
            $jamAjarMasuk    = $jamMulai;  
            $jamAjarKeluar   = $jamSelesai;
            
            $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $ruangLab)
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
                                ->where('kuliahpengganti.id_lab', '=', $ruangLab)
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

            $nama_baru = $this->enkripsi($nama);
            $keterangan_baru = $this->enkripsi($keterangan);
            $email_baru = $this->enkripsi($email);

            if($cek == 0){
            $pinjam  =  new PinjamLab();
            $pinjam  -> jam_pinjam          = $jamMulai.' - '.$jamSelesai;
            $pinjam  -> tanggal_pinjam      = $this->caritanggal($tanggalPinjam);
            $pinjam  -> nama_pinjam         = $nama_baru;
            $pinjam  -> judul_pinjam        = $judul;
            $pinjam  -> keterangan_pinjam   = $keterangan_baru;
            $pinjam  -> email_pinjam        = $email_baru;
            $pinjam  -> id_lab              = $ruangLab;

                
                    
                if($pinjam->save())
                {
                    alert()->html('Berhasil Menambah Data!', 'Peminjaman Lab a.n. <strong>'.$nama.'</strong><br> pada tanggal <strong>'.$tanggal.'</strong> Berhasil Dibuat.', 'success')->autoClose(10000);
                    return redirect('/admin/pinjamlab');
                }
                else
                {
                alert()->html('Gagal Menambah Data!', 'Mohon periksa kembali kesesuaian inputan Anda.', 'error')->autoClose(10000);
                return redirect('/admin/pinjamlab/tambah');
                }
            }
            else{
                alert()->html('Gagal Menambah Data!', 'Peminjaman lab anda bentrok dengan jadwal yang ada', 'error')->autoClose(10000);
                return redirect('/admin/pinjamlab/tambah');
                
            } 
            
    }

    function ubah(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $pinjam  = PinjamLab::find($id);

        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return view('ubahpinjamlab')
        ->with('pinjam', $pinjam)
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Pinjam Lab');

    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        $nama           = $request->get('nama');
        $judul          = $request->get('judul');
        $keterangan     = $request->get('keterangan');
        $tanggalPinjam  = $request->get('tanggal');
        $jamMulai       = $request->get('jamMulai');
        $jamSelesai     = $request->get('jamSelesai');
        $ruangLab       = $request->get('lab');
        $email          = $request->get('email');

        $tanggal    = $this->caritanggal($tanggalPinjam);
        $hari       = $this->carihari($tanggal);

        $cek = 0;
        $jamAjarMasuk    = $jamMulai;  
        $jamAjarKeluar   = $jamSelesai;
        
        $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $ruangLab)
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
                            ->where('kuliahpengganti.id_lab', '=', $ruangLab)
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

        if($cek == 0){
        $pinjam  =  PinjamLab::find($id);
        $pinjam  -> jam_pinjam          = $jamMulai.' - '.$jamSelesai;
        $pinjam  -> tanggal_pinjam      = $this->caritanggal($tanggalPinjam);
        $pinjam  -> nama_pinjam         = $nama;
        $pinjam  -> judul_pinjam        = $judul;
        $pinjam  -> keterangan_pinjam   = $keterangan;
        $pinjam  -> email_pinjam        = $email;
        $pinjam  -> id_lab              = $ruangLab;

            
                
            if($pinjam->save())
            {
                alert()->html('Berhasil Menambah Data!', 'Peminjaman Lab a.n. <strong>'.$nama.'</strong><br> pada tanggal <strong>'.$tanggal.'</strong> Berhasil Dibuat.', 'success')->autoClose(10000);
                return redirect('/admin/pinjamlab');
            }
            else
            {
            alert()->html('Gagal Menambah Data!', 'Mohon periksa kembali kesesuaian inputan Anda.', 'error')->autoClose(10000);
            return redirect('/admin/pinjamlab/ubah/'.$id);
            }
        }
        else{
            alert()->html('Gagal Menambah Data!', 'Peminjaman lab anda bentrok dengan jadwal yang ada', 'error')->autoClose(10000);
            return redirect('/admin/pinjamlab/ubah/'.$id);
            
        } 
    }


    function hapus(Request $request, $id)
    {
        $pinjam    = PinjamLab::find($id);

        if($pinjam -> delete())
        {
            alert()->html('Berhasil Hapus Data', 'Berhasil Menghapus Data Peminjaman Lab', 'success')->autoClose(10000);
            return redirect('/admin/pinjamlab');
        }
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

    function enkripsi($plaintext){
        $inputText = $plaintext;
         $inputKey = "abcdefghijuklmno0123456789012345";
         $blockSize = 256;
         $aes = new Prosesaes($inputText, $inputKey, $blockSize);
         $enc = $aes->encrypt();

         return $enc;
    }

    function dekripsi($plaintext){
        $inputText = $plaintext;
        $inputKey = "abcdefghijuklmno0123456789012345";
        $blockSize = 256;
        $aes = new Prosesaes($inputText, $inputKey, $blockSize);
        $aes->setData($inputText);
        $dec=$aes->decrypt();

        return $dec;
    }

}

?>