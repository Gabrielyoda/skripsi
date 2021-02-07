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
                    ->where('pinjamlab.status' , '=', 0)
                    ->select('pinjamlab.id_pinjam','pinjamlab.jam_pinjam','pinjamlab.tanggal_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','pinjamlab.keterangan_pinjam','pinjamlab.email_pinjam')
                    ->get();

                    // for($i=0; $i<count($join); $i++) {
                    //     $join[$i]->nama_pinjam = $this->dekripsi($join[$i]->nama_pinjam);
                    // }

        return view('pinjamlab')
        ->with('join', $join)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Pinjam Lab');
    }

    function history(Request $request){
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $join   = DB::table('pinjamlab')
                    ->join('lab', 'pinjamlab.id_lab','=','lab.id_lab')
                    ->where('pinjamlab.status' , '=', 1)
                    ->orWhere('pinjamlab.status','=', 2)
                    ->select('pinjamlab.id_pinjam','pinjamlab.jam_pinjam','pinjamlab.tanggal_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','pinjamlab.keterangan_pinjam','pinjamlab.email_pinjam','lab.nama_lab','lab.kapasitas_lab','pinjamlab.status')
                    ->orderBy('pinjamlab.tanggal_pinjam' , 'desc')
                    ->get();
        
                    // for($i=0; $i<count($join); $i++) {
                    //     $join[$i]->nama_pinjam = $this->dekripsi($join[$i]->nama_pinjam);
                    // }

        return view('historypeminjaman')
        ->with('join', $join)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'History Peminjaman Lab');
    }

    function tambah(Request $request)
    { 
        $user = User::find($request->session()->get('nim'));

        $id_user = $user -> id_user;
        $nama = $user -> nama;


        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return view('tambahpinjamlab')
        ->with('lab', $lab)
        ->with('id_user', $id_user)
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
            $cariLab        = Lab::select('id_lab')->where('nama_lab', $request->get('ruangLab'))->first();
            $ruangLab       = $cariLab->id_lab;
            $email          = $request->get('email');
            $nohp           = $request->get('nohp');
            $id_user        = $request->get('id_user');
            $status         = 1;
            $comment        = "Dibuat oleh Admin";

           

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

            $cektanggal     = DB::table('pinjamlab')
                                ->select('jam_pinjam')
                                ->where('id_lab', '=', $ruangLab)
                                ->where('tanggal_pinjam', '=', $tanggal)
                                ->get();

               
            foreach($cektanggal as $cektanggals) 
            {
                $jamKeluar  = substr($cektanggals -> jam_pinjam, -5);
                $jamMasuk   = substr($cektanggals -> jam_pinjam, 0, -8);
                                                                                    
                    if($jamKeluar >= $jamAjarMasuk && $jamMasuk <= $jamAjarKeluar) 
                        {
                            $cek = 1;
                        }
            }

            // $nama_baru = $this->enkripsi($nama);
            // $keterangan_baru = $this->enkripsi($keterangan);
            // $email_baru = $this->enkripsi($email);

            if($cek == 0){
            $pinjam  =  new PinjamLab();
            $pinjam  -> jam_pinjam          = $jamMulai.' - '.$jamSelesai;
            $pinjam  -> tanggal_pinjam      = $this->caritanggal($tanggalPinjam);
            $pinjam  -> nama_pinjam         = $nama;
            $pinjam  -> judul_pinjam        = $judul;
            $pinjam  -> keterangan_pinjam   = $keterangan;
            $pinjam  -> email_pinjam        = $email;
            $pinjam  -> id_lab              = $ruangLab;
            $pinjam  -> nohp                = $nohp;
            $pinjam  -> id_user             = $id_user;
            $pinjam  -> status              = $status;
            $pinjam  -> comment             = $comment;

                
                    
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
        $id_user = $user -> id_user;

        $pinjam  = PinjamLab::find($id);

        // $pinjam->nama_pinjam = $this->dekripsi($pinjam->nama_pinjam);
        // $pinjam->keterangan_pinjam = $this->dekripsi($pinjam->keterangan_pinjam);
        // $pinjam->email_pinjam = $this->dekripsi($pinjam->email_pinjam);

        // Fungsi mengubah date yyyy-mm-dd ke dd-MM-yyyy atau format Indonesia
        $pinjam->tanggal_pinjam = $this->cektanggal($pinjam->tanggal_pinjam);
        
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return view('ubahpinjamlab')
        ->with('pinjam', $pinjam)
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('id_user', $id_user)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Pinjam Lab');

    }

    function view(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;
        $id_user = $user -> id_user;

        $pinjam  = PinjamLab::find($id);

        // $pinjam->nama_pinjam = $this->dekripsi($pinjam->nama_pinjam);
        // $pinjam->keterangan_pinjam = $this->dekripsi($pinjam->keterangan_pinjam);
        // $pinjam->email_pinjam = $this->dekripsi($pinjam->email_pinjam);

        
        $tanggal = $pinjam->tanggal_pinjam;
        $hari       = $this->carihari($tanggal);
        // Fungsi mengubah date yyyy-mm-dd ke dd-MM-yyyy atau format Indonesia
        $pinjam->tanggal_pinjam = $this->cektanggal($pinjam->tanggal_pinjam);

        
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();
        $labApi = $lab;

        $jamAjar = $pinjam->jam_pinjam;
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);

        //pengecekan jadwal
        $cekwaktu       = Jadwal::select('jam_ajar','id_lab','kelompok')    ->where('hari', $hari)
                                                        ->where('semester', $request->session()->get('semester'))
                                                        ->where('tahunajaran', $request->session()->get('tahunajaran'))
                                                        ->get();

       

        if(count($cekwaktu)!=0){
            foreach($cekwaktu as $cekwaktus) 
            {
                //ini untuk mengecek jadwal bentrok
                for($i=0;$i<count($cekwaktu);$i++){
                $jamMasuk[$i]   = substr($cekwaktu[$i] -> jam_ajar, 0, -8);
                $jamKeluar[$i]  = substr($cekwaktu[$i] -> jam_ajar, -5);
                }
                
               
                $lab2[] = array();
                $j=0;
                for($i=0;$i<count($cekwaktu);$i++){
                    if($jamKeluar[$i] >= $jamAjarMasuk && $jamMasuk[$i] <= $jamAjarKeluar) {
                        $lab2[$j] = $cekwaktu[$i]-> id_lab;
                        $j++;
                    }
                    else{
                        
                    }
                }
               
              
                
            }

            $k=0;
            for($i=0;$i<count($lab);$i++){
                for($j=0;$j<count($lab2);$j++){
                    if($lab[$i] -> id_lab == $lab2[$j]){
                        if($lab[$i] -> nama_lab != "Lab Bentrok"){
                            $lab[$i] -> nama_lab = "Lab Bentrok";
                        }
                    
                    }

                }
            }

            $lab3 = array();

            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $k++;
                }
            }
            
            
        }
        else{
            $k=0;
            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $k++;
                }
            }
        }
        
       
        
        //pengecekan kp
        $cektanggal     = DB::table('jadwal')
                            ->join('kuliahpengganti', 'jadwal.id_jadwal','=','kuliahpengganti.id_jadwal')
                            ->select('kuliahpengganti.jam_pengganti','kuliahpengganti.id_lab')
                            ->where('kuliahpengganti.tanggal_pengganti', '=', $tanggal)
                            ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                            ->where('jadwal.semester','=',$request->session()->get('semester'))
                            ->get();

                           


        if(count($cektanggal)!=0){
            foreach($cektanggal as $cektanggals) 
            {
               
               
                
                for($i=0;$i<count($cektanggal);$i++){
                    $jamMasuk[$i]    = substr($cektanggal[$i] -> jam_pengganti, 0, -8);
                    $jamKeluar[$i]   = substr($cektanggal[$i] -> jam_pengganti, -5);
                }

                
                $j=0;
                for($i=0;$i<count($cektanggal);$i++){
                    if($jamKeluar[$i] >= $jamAjarMasuk && $jamMasuk[$i] <= $jamAjarKeluar) {
                        $lab2[$j] = $cektanggal[$i]-> id_lab;
                        $j++;
                    }
                    else{
                        
                    }
                }
                
            }

           

            for($i=0;$i<count($lab);$i++){
                for($j=0;$j<count($lab2);$j++){
                    if($lab[$i] -> id_lab == $lab2[$j]){
                        if($lab[$i] -> nama_lab != "Lab Bentrok"){
                            $lab[$i] -> nama_lab = "Lab Bentrok";
                        }
                    
                    }

                }
            }

            $lab3 = array();
            $k=0;
            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $k++;
                }
            }
        }
        else{
            $k=0;
            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $k++;
                }
            }
        }

      

        //pengecekan peminjaman
        $cektanggal     = DB::table('pinjamlab')
                                                    ->select('jam_pinjam' ,'id_lab')
                                                    ->where('status', '=', 1)
                                                    ->where('tanggal_pinjam', '=', $tanggal)
                                                    ->get();

        
        if(count($cektanggal)!=0){
            foreach($cektanggal as $cektanggals) 
            {
                for($i=0;$i<count($cektanggal);$i++){
                    $jamMasuk[$i]    = substr($cektanggal[$i] -> jam_pinjam, 0, -8);
                    $jamKeluar[$i]   = substr($cektanggal[$i] -> jam_pinjam, -5);
                }

                $j=0;
                for($i=0;$i<count($cektanggal);$i++){
                    if($jamKeluar[$i] >= $jamAjarMasuk && $jamMasuk[$i] <= $jamAjarKeluar) {
                        $lab2[$j] = $cektanggal[$i]-> id_lab;
                        $j++;
                    }
                    else{
                       
                    }
                }

            }

            
            for($i=0;$i<count($lab);$i++){
                for($j=0;$j<count($lab2);$j++){
                    if($lab[$i] -> id_lab == $lab2[$j]){
                        if($lab[$i] -> nama_lab != "Lab Bentrok"){
                            $lab[$i] -> nama_lab = "Lab Bentrok";
                        }
                    
                    }

                }
            }

            $lab3 = array();
            $k=0;
            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $k++;
                }
            }
        }
        else{
            $k=0;
            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $k++;
                }
            }
        }

      
        return view('viewpinjamlab')
        ->with('pinjam', $pinjam)
        ->with('lab', $lab3)
        ->with('nama', $nama)
        ->with('id_user', $id_user)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Pinjam Lab');

    }

    function prosessetuju(Request $request)
    {
        $id             = $request->get('id');
        $status         = 1;
        $comment        = $request->get('comment');
        $cariLab        = Lab::select('id_lab')->where('nama_lab', $request->get('lab'))->first();
        $ruangLab       = $cariLab->id_lab;

       

       
        $pinjam  =  PinjamLab::find($id);
        $pinjam  -> status              = $status;
        $pinjam  -> comment             = $comment;
        $pinjam  -> id_lab              = $ruangLab;
        


            
                
            if($pinjam->save())
            {
                alert()->html('Berhasil Menyetujui Data', 'Peminjaman Lab  Berhasil Disetujui', 'success')->autoClose(10000);
                return redirect('/admin/pinjamlab');
            }
            else
            {
            alert()->html('Gagal Menambah Data!', 'Mohon periksa kembali kesesuaian inputan Anda.', 'error')->autoClose(10000);
            return redirect('/admin/pinjamlab/ubah/'.$id);
            }
        
    }

    function tolak(Request $request)
    {
        $id             = $request->get('id');
        $status         = 2;
        $comment        = $request->get('comment');
        $ruangLab       = 0;
        
        $pinjam  =  PinjamLab::find($id);
        $pinjam  -> status              = $status;
        $pinjam  -> comment             = $comment;
        $pinjam  -> id_lab              = $ruangLab;


            
                
            if($pinjam->save())
            {
                alert()->html('Data peminjaman Telah ditolak', 'Peminjaman Lab  Berhasil Disetujui', 'success')->autoClose(10000);
                return redirect('/admin/pinjamlab');
            }
            else
            {
            alert()->html('Gagal Menambah Data!', 'Mohon periksa kembali kesesuaian inputan Anda.', 'error')->autoClose(10000);
            }
        
    }

    function prosesubah(Request $request)
    {
        $id             = $request->get('id');
        $nama           = $request->get('nama');
        $judul          = $request->get('judul');
        $keterangan     = $request->get('keterangan');
        $tanggalPinjam  = $request->get('tanggal');
        $jamMulai       = $request->get('jamMulai');
        $jamSelesai     = $request->get('jamSelesai');
        $ruangLab       = $request->get('lab');
        $email          = $request->get('email');
        $nohp           = $request->get('nohp');
        $id_user        = $request->get('id_user');

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

        // $nama_baru = $this->enkripsi($nama);
        // $keterangan_baru = $this->enkripsi($keterangan);
        // $email_baru = $this->enkripsi($email);

        if($cek == 0){
        $pinjam  =  PinjamLab::find($id);
        $pinjam  -> jam_pinjam          = $jamMulai.' - '.$jamSelesai;
        $pinjam  -> tanggal_pinjam      = $this->caritanggal($tanggalPinjam);
        $pinjam  -> nama_pinjam         = $nama_baru;
        $pinjam  -> judul_pinjam        = $judul;
        $pinjam  -> keterangan_pinjam   = $keterangan_baru;
        $pinjam  -> email_pinjam        = $email_baru;
        $pinjam  -> id_lab              = $ruangLab;
        $pinjam  -> nohp                = $nohp;
        $pinjam  -> id_user             = $id_user;


            
                
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
    // mengubah format yyyy-mm-dd ke format Indonesia (dd-MM-yyyy)
    function cektanggal($tanggal) {
        $bulan = array (1 =>'Januari',2 =>'Februari',3 =>'Maret',4 =>'April',5 =>'Mei',6 =>'Juni',7 =>'Juli',8 =>'Agustus',9 =>'September',10 =>'Oktober',11 =>'November',12 =>'Desember');
        
        $pecah = explode('-', $tanggal);
        
        return $pecah[2].' '.$bulan[(int)$pecah[1]].' '. $pecah[0];
    }
}

?>