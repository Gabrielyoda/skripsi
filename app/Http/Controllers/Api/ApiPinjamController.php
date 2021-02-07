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
use App\User;

class ApiPinjamController extends Controller
{
    public function lihatpeminjaman(Request $request){

        $pinjam = auth()->user()->pinjam;

        $id         = $request->get('id_user');
        $id_user    = $this->dekripsi($id);
        $id         = substr($id_user, 3);
       
        $join   = DB::table('pinjamlab')
                    ->join('lab', 'pinjamlab.id_lab','=','lab.id_lab')
                    ->select('pinjamlab.id_pinjam','pinjamlab.jam_pinjam','pinjamlab.tanggal_pinjam','pinjamlab.nama_pinjam','pinjamlab.judul_pinjam','pinjamlab.keterangan_pinjam','pinjamlab.email_pinjam','lab.nama_lab','pinjamlab.status','pinjamlab.comment')
                    ->where('pinjamlab.id_user','=',$id)
                    ->get();
                

                    for($i=0; $i<count($join); $i++) {
                        $join[$i]->id_pinjam = $this->enkripsi($join[$i]->id_pinjam);
                        
                        if($join[$i]->status == 0 || $join[$i]->status == 2){
                            $join[$i]->nama_lab = "Lab Tidak DIketahui";
                        }
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
            $id_lab         = 0;
            $id_user        = $this->dekripsi($request->id_user);
            $id_user        = substr($id_user, 3);
            $nohp           = $request->nohp;
            $status = 0;

            $tanggal    = $this->caritanggal($tanggalPinjam);
            $hari       = $this->carihari($tanggal);

            $cek = 0;
            $jamAjarMasuk    = $jamMulai;  
            $jamAjarKeluar   = $jamSelesai;
            

        if($cek == 0){

            //menambah kan str untuk meminalkan eror
            $jam_pinjam             = "enc" .$jamMulai.' - '.$jamSelesai;
            $tanggal_pinjam         = "enc" .$this->caritanggal($tanggalPinjam);
            $nama_pinjam            = "enc" .$nama;
            $judul_pinjam           = "enc" .$judul;
            $keterangan_pinjam      = "enc" .$keterangan;
            $email_pinjam           = "enc" .$email;
            $id_lab                 = "enc" .$id_lab;
            $id_user                = "enc" .$id_user;
            $nohp                   = "enc" .$nohp;
            $status                 = "enc" .$status;

            //proses enkripsi
            $jam_pinjam             = $this->enkripsi($jam_pinjam);
            $tanggal_pinjam         = $this->enkripsi($tanggal_pinjam);
            $nama_pinjam            = $this->enkripsi($nama_pinjam);
            $judul_pinjam           = $this->enkripsi($judul_pinjam);
            $keterangan_pinjam      = $this->enkripsi($keterangan_pinjam);
            $email_pinjam           = $this->enkripsi($email_pinjam);
            $id_lab                 = $this->enkripsi($id_lab);
            $id_user                = $this->enkripsi($id_user);
            $nohp                   = $this->enkripsi($nohp);
            $status                 = $this->enkripsi($status);

            $data[] = array(
                "jam_pinjam"=>  $jam_pinjam,
                "tanggal_pinjam"=> $tanggal_pinjam,
                "nama_pinjam" => $nama_pinjam,
                "judul_pinjam" => $judul_pinjam,
                "keterangan_pinjam"=>  $keterangan_pinjam,
                "email_pinjam"=> $email_pinjam,
                "id_lab" => $id_lab,
                "id_user" => $id_user,
                "nohp" => $nohp,
                "status" => $status
            );

            return response()->json([
                        'success' => true,
                        'message' => 'Data berhasil dienkripsi',
                        "jam_pinjam"=>  $jam_pinjam,
                        "tanggal_pinjam"=> $tanggal_pinjam,
                        "nama_pinjam" => $nama_pinjam,
                        "judul_pinjam" => $judul_pinjam,
                        "keterangan_pinjam"=>  $keterangan_pinjam,
                        "email_pinjam"=> $email_pinjam,
                        "id_lab" => $id_lab,
                        "id_user" => $id_user,
                        "nohp" => $nohp,
                        "status" => $status
            ]); 

        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman lab anda bentrok dengan jadwal yang ada'
            ]);
        
        } 
            
    }

    function dekripsipeminjaman(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'jam_pinjam' => 'required',
            'tanggal_pinjam' => 'required',
            'nama_pinjam' => 'required',
            'judul_pinjam' => 'required',
            'keterangan_pinjam' => 'required',
            'email_pinjam' => 'required',
            'id_lab' => 'required',
            'id_user' => 'required',
            'nohp' => 'required',
            'status' => 'required'
           
        ]);
        
        $jam_pinjam           = $request->jam_pinjam;
        $tanggal_pinjam       = $request->tanggal_pinjam;
        $nama_pinjam          = $request->nama_pinjam;
        $judul_pinjam         = $request->judul_pinjam;
        $keterangan_pinjam    = $request->keterangan_pinjam;
        $email_pinjam         = $request->email_pinjam;
        $id_lab               = $request->id_lab;
        $id_user              = $request->id_user;
        $nohp                 = $request->nohp;
        $status               = $request->status;

        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'message' => $validator->errors()
            ]
            );
        }

        //proses dekripsi
        $jam_pinjam    = $this->dekripsi($jam_pinjam);
        $jam_pinjam    = substr($jam_pinjam, 3);
        $tanggal_pinjam    = $this->dekripsi($tanggal_pinjam);
        $tanggal_pinjam    = substr($tanggal_pinjam, 3);
        $nama_pinjam    = $this->dekripsi($nama_pinjam);
        $nama_pinjam    = substr($nama_pinjam, 3);
        $judul_pinjam    = $this->dekripsi($judul_pinjam);
        $judul_pinjam    = substr($judul_pinjam, 3);
        $keterangan_pinjam    = $this->dekripsi($keterangan_pinjam);
        $keterangan_pinjam    = substr($keterangan_pinjam, 3);
        $email_pinjam    = $this->dekripsi($email_pinjam);
        $email_pinjam    = substr($email_pinjam, 3);
        $id_lab    = $this->dekripsi($id_lab);
        $id_lab    = substr($id_lab, 3);
        $id_user    = $this->dekripsi($id_user);
        $id_user    = substr($id_user, 3);
        $nohp    = $this->dekripsi($nohp);
        $nohp    = substr($nohp, 3);
        $status    = $this->dekripsi($status);
        $status    = substr($status, 3);

        $user = User::select('nama')->where('id_user', $id_user)->get();

       
        if(count($user)==1){
            $pinjam  =  new PinjamLab();
            $pinjam  -> jam_pinjam          = $jam_pinjam;
            $pinjam  -> tanggal_pinjam      = $tanggal_pinjam;
            $pinjam  -> nama_pinjam         = $nama_pinjam;
            $pinjam  -> judul_pinjam        = $judul_pinjam;
            $pinjam  -> keterangan_pinjam   = $keterangan_pinjam;
            $pinjam  -> email_pinjam        = $email_pinjam;
            $pinjam  -> id_user             = $id_user;
            $pinjam  -> nohp                = $nohp;
            $pinjam  -> status              = $status;
            $pinjam  -> id_lab              = $id_lab;
                
                    
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
                'message' => 'Data Tidak Dapat Disimpan'
            ]);
        }     
    }

    function prosestambahweb(Request $request)
    {
        $pinjam = auth()->user()->pinjam;
        // $cariLab    = Lab::select('id_lab')->where('nama_lab', $request->get('lab'))->first();
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();
        $status = 0;

        

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'judul' => 'required',
            'keterangan'=> 'required',
            'tanggal' => 'required',
            'jamMulai' => 'required',
            'jamSelesai'=> 'required',
            
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
            $id_lab         = 0;
            $email          = $request->email;
            $id_user        = $request->id_user;
            $nohp           = $request->nohp;

            $tanggal    = $this->caritanggal($tanggalPinjam);
            $hari       = $this->carihari($tanggal);

            $cek = 0;
            $jamAjarMasuk    = $jamMulai;  
            $jamAjarKeluar   = $jamSelesai;
            
            

            $nama_baru = $this->enkripsi($nama);
            $keterangan_baru = $this->enkripsi($keterangan);
            $email_baru = $this->enkripsi($email);

            if($cek == 0){
            $pinjam  =  new PinjamLab();
            $pinjam  -> jam_pinjam          = $jamMulai.' - '.$jamSelesai;
            $pinjam  -> tanggal_pinjam      = $this->caritanggal($tanggalPinjam);
            $pinjam  -> nama_pinjam         = $nama;
            $pinjam  -> judul_pinjam        = $judul;
            $pinjam  -> keterangan_pinjam   = $keterangan;
            $pinjam  -> email_pinjam        = $email;
            $pinjam  -> status              = $status;
            $pinjam  -> id_user             = $id_user;
            $pinjam  -> nohp                = $nohp;
            $pinjam  -> id_lab              = $id_lab;

                
                    
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
