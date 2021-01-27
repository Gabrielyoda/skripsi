<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jadwal;
use App\TahunAjaran;
use App\Semester;
use App\Lab;
use App\PinjamLab;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Aes256\Prosesaes;

class ApiPinjamController extends Controller
{
    public function lihatpeminjaman(Request $request){

        $pinjam = auth()->user()->pinjam;

        $id         = $request->get('id_user');

        
        $join   = DB::table('pinjamlab')
                    ->join('lab', 'pinjamlab.id_lab','=','lab.id_lab')
                    ->select('pinjamlab.id_pinjam','pinjamlab.jam_pinjam','pinjamlab.tanggal_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','pinjamlab.keterangan_pinjam','pinjamlab.email_pinjam','lab.nama_lab','lab.kapasitas_lab')
                    ->where('pinjamlab.id_user','=',$id)
                    ->get();

                    for($i=0; $i<count($join); $i++) {
                        $join[$i]->id_pinjam = $this->enkripsi($join[$i]->id_pinjam);
                        $join[$i]->nama_pinjam = $this->dekripsi($join[$i]->nama_pinjam);
                        $join[$i]->keterangan_pinjam = $this->dekripsi($join[$i]->keterangan_pinjam);
                        $join[$i]->email_pinjam = $this->dekripsi($join[$i]->email_pinjam);
                    }

        return response()->json([
            'success' => true,
            'data' => $join
        ]);

    }

    public function Lab(){
               
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return response()->json([
            'error' => true,
            'data' => $lab
        ]);

    }

    function prosestambah(Request $request)
    {
        $pinjam = auth()->user()->pinjam;
        
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();
        

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'judul' => 'required',
            'keterangan'=> 'required',
            'tanggal' => 'required',
            'jamMulai' => 'required',
            'jamSelesai'=> 'required',
            'lab' => 'required',
            'email' => 'required',
            'id_user' => 'required',
            'nohp' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

            $nama           = $request->nama;
            $judul          = $request->judul;
            $keterangan     = $request->keterangan;
            $tanggalPinjam  = $request->tanggal;
            $jamMulai       = $request->jamMulai;
            $jamSelesai     = $request->jamSelesai;
            $ruangLab       = $request->lab;
            $email          = $request->email;
            $id_user        = $request->id_user;
            $nohp           = $request->nohp;

            $tanggal    = $this->caritanggal($tanggalPinjam);
            $hari       = $this->carihari($tanggal);

            $cek = 0;
            $jamAjarMasuk    = $jamMulai;  
            $jamAjarKeluar   = $jamSelesai;
            
            $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $ruangLab)
                                                            ->where('hari', $hari)
                                                            ->where('semester', $semester->semester)
                                                            ->where('tahunajaran', $tahun->tahunajaran)
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
                                ->where('jadwal.tahunajaran','=',$semester->semester)
                                ->where('jadwal.semester','=',$tahun->tahunajaran)
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
            $pinjam  -> id_user             = $id_user;
            $pinjam  -> nohp                = $nohp;

                
                    
                if($pinjam->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'data berhasil disimpan'
                    ]); 
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Peminjaman lab anda bentrok dengan jadwal yang ada'
                    ]);
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman lab anda bentrok dengan jadwal yang ada'
                ]);
            
            } 
            
    }

    function prosestambahweb(Request $request)
    {
        $pinjam = auth()->user()->pinjam;
        $cariLab    = Lab::select('id_lab')->where('nama_lab', $request->get('lab'))->first();
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();
        

        

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'judul' => 'required',
            'keterangan'=> 'required',
            'tanggal' => 'required',
            'jamMulai' => 'required',
            'jamSelesai'=> 'required',
            'lab' => 'required',
            'email' => 'required',
            'id_user' => 'required',
            'nohp' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

            $nama           = $request->nama;
            $judul          = $request->judul;
            $keterangan     = $request->keterangan;
            $tanggalPinjam  = $request->tanggal;
            $jamMulai       = $request->jamMulai;
            $jamSelesai     = $request->jamSelesai;
            $ruangLab       = $cariLab->id_lab;
            $email          = $request->email;
            $id_user        = $request->id_user;
            $nohp           = $request->nohp;

            $tanggal    = $this->caritanggal($tanggalPinjam);
            $hari       = $this->carihari($tanggal);

            $cek = 0;
            $jamAjarMasuk    = $jamMulai;  
            $jamAjarKeluar   = $jamSelesai;
            
            $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $ruangLab)
                                                            ->where('hari', $hari)
                                                            ->where('semester', $semester->semester)
                                                            ->where('tahunajaran', $tahun->tahunajaran)
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
            $pinjam  -> id_user             = $id_user;
            $pinjam  -> nohp                = $nohp;

                
                    
                if($pinjam->save())
                {
                    $request->session() -> put('token', $request->token);
                    $request->session() -> put('nim', $id_user);
                    return response()->json([
                        'success' => true,
                        'message' => 'data berhasil disimpan'
                    ]); 
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Peminjaman lab anda bentrok dengan jadwal yang ada'
                    ]);
                }
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman lab anda bentrok dengan jadwal yang ada'
                ]);
            
            } 
            
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
