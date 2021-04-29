<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Jadwal;
use App\TahunAjaran;
use App\Semester;
use App\Lab;
use App\KuliahPengganti;
use App\Matakuliah;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Validator;
use App\Aes256\Prosesaes;
use App\User;

class ApiJadwalController extends Controller
{

    //ini untuk get data jadwal hari ini
    public function jadwal(Request $request)
    {
        $jadwal = auth()->user()->jadwal;
        $hari = $request->get('hari');
        $tanggal = $request->get('tanggal');

       
        
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

                      
        $jadwal   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','users.id_user','users.nama','lab.nama_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=', $hari)
                    ->orderBy('jadwal.jam_ajar')
                    ->get()
                    ->toArray();

        $joinKP = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->select('jadwal.kelompok','kuliahpengganti.tanggal_pengganti',DB::raw('kuliahpengganti.jam_pengganti as jam_ajar'),'matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','users.id_user','users.nama','lab.nama_lab','lab.kapasitas_lab')
                    ->where('kuliahpengganti.tanggal_pengganti','=', $tanggal)
                    ->where('jadwal.tahunajaran','=', $tahun->tahunajaran)
                    ->where('jadwal.semester','=', $semester->semester)
                    ->get()
                    ->toArray();

        $joinPinjam  = DB::table('pinjamlab')
                    ->join('lab', 'lab.id_lab','=','pinjamlab.id_lab')
                    ->select(DB::raw('pinjamlab.jam_pinjam as jam_ajar'),DB::raw('pinjamlab.nama_pinjam as nama'),DB::raw('pinjamlab.judul_pinjam as nama_mtk'),'lab.nama_lab',DB::raw('pinjamlab.id_pinjam as kelompok'))
                    ->where('pinjamlab.tanggal_pinjam','=', $tanggal)
                    ->where('pinjamlab.status' , '=', 1)
                    ->get()
                    ->toArray();

                    for($i=0; $i<count($joinPinjam); $i++) {
                        $joinPinjam[$i]->nama = $this->dekripsi($joinPinjam[$i]->nama);
                        $joinPinjam[$i]->kelompok = " ";
                    }

        $jadwalAll=array_merge($jadwal,$joinKP,$joinPinjam);
                    
        
        
        return response()->json([
            'success' => true,
            'datajadwal' => $jadwalAll
        ]);
    }


    //ini untuk jadwal jam sekarang
    public function jadwalJam()
    {
        $jadwal = auth()->user()->jadwal;
        
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $hari_ini       = $this->cekhari();
                      
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

        $jadwal   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','users.id_user','users.nama','lab.nama_lab')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->where('jadwal.hari','=', $hari_ini)
                    ->where(\DB::raw('substr(jam_ajar, 1, 5)'), '<=', $jam)
                    ->where(\DB::raw('substr(jam_ajar, 9)'), '>=', $jam)
                    ->orderBy('matakuliah.nama_mtk')
                    ->get()
                    ->toArray();

        $joinKP = DB::table('jadwal')
                    ->join('kuliahpengganti', 'kuliahpengganti.id_jadwal','=','jadwal.id_jadwal')
                    ->join('lab', 'kuliahpengganti.id_lab','=','lab.id_lab')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->select('kuliahpengganti.id_kp','jadwal.kelompok','kuliahpengganti.tanggal_pengganti','kuliahpengganti.jam_pengganti','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','users.id_user','users.nama','lab.nama_lab','lab.kapasitas_lab')
                    ->where('kuliahpengganti.tanggal_pengganti','=', date('Y-m-d'))
                    ->where('jadwal.tahunajaran','=', $tahun->tahunajaran)
                    ->where('jadwal.semester','=', $semester->semester)
                    ->get()
                    ->toArray();

        $jadwalAll=array_merge($jadwal,$joinKP);
                    
        
        
        return response()->json([
            'success' => true,
            'datajadwal' => $jadwal,
            'datapengganti' => $joinKP
        ]);
    }

    public function Lab(){
               
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();

        return response()->json([
            'error' => false,
            'data' => $lab
        ]);

    }

    function cari_lab(Request $request)
    { 
        
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jam_ajar'=> 'required'
           
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

            
            $keterangan     = $request->keterangan;
            $tanggalPinjam  = $request->tanggal;
            $jamAjar        = $request->jam_ajar;

            $tanggal    = $this->caritanggal($tanggalPinjam);
            $hari       = $this->carihari($tanggal);

            

            $cek = 0;


        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();
        $lab    = Lab::select('*')->orderBy('nama_lab')->get();
        $labApi = $lab;

        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);

       

        //pengecekan jadwal
        $cekwaktu       = Jadwal::select('jam_ajar','id_lab')    ->where('hari', $hari)
                                                        ->where('semester', $semester->semester)
                                                        ->where('tahunajaran', $tahun->tahunajaran)
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
                            ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                            ->where('jadwal.semester','=',$semester->semester)
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

        $k=0;
        $labApi = array();
            for($i=0;$i<count($lab);$i++){
                if($lab[$i] -> nama_lab != "Lab Bentrok"){
                    $lab3[$k] = $lab[$i] -> nama_lab;
                    $labApi[$k] = array(
                    "id_lab"=>  $lab[$i] -> id_lab,
                    "nama_lab"=> $lab[$i] -> nama_lab,
                    "spesifikasi" => $lab[$i] -> spesifikasi
                );
                    $k++;
                }
            }

        if(count($labApi)==0){
            $labApi[$k] = array(
                "id_lab"=>  999,
                "nama_lab"=> "Tidak Ada Lab Yang tersedia"
            );
        }


        return response()->json([
            'error' => false,
            'data' => $labApi
        ]);


       

    }

    public function matkul(){

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();


        $matkul = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->select('matakuliah.id_mtk','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk')
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->groupBy('matakuliah.kd_mtk')
                    ->get();

                    return response()->json([
                        'error' => false,
                        'data' => $matkul
                    ]);
    }

    

    function caridosen(Request $request)
    {   
        $id         = $request->get('idmtk');

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $dosen  = DB::table('jadwal')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->select('jadwal.id_user', 'users.id_user','users.nama')
                    ->where('jadwal.id_mtk','=',$id)
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->groupBy('jadwal.id_user')
                    ->get();

        $sks    = Matakuliah::select('sks_mtk')->where('id_mtk','=',$id)->first();

        for($i=0; $i<count($dosen); $i++) {
            $str = "usr" .$dosen[$i]->id_user;
            $dosen[$i]->id_user = $this->enkripsi($str);
        }

        return response()->json([
            'error' => false,
            'data' => $dosen
            ]);
    }

    function cariMatkul(Request $request)
    {   
        $id         = $request->get('iddosen');
        $id_user    = $this->dekripsi($id);
        $id         = substr($id_user, 3);
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $dosen  = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->select('matakuliah.id_mtk','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk')
                    ->Where('jadwal.id_user','=',$id)
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->groupBy('jadwal.id_user')
                    ->get();

      

        if(count($dosen) == 0){
                $data = array();
                $data[] = array("id_mtk"=> 0,"kd_mtk"=> "","nama_mtk"=> "Dosen Tidak Ada Jadwal Matakuliah","sks_mtk"=> 0);
            return response()->json([
                'error' => false,
                "data" => $data
                ]);  
        }
        else{
            return response()->json([
                'error' => false,
                'data' => $dosen
                ]);
        }

    }

    function carikelompok(Request $request)
    {   
        $idmtk      = $request->get('idmtk');
        $iddosen    = $request->get('iddosen');
        $id_user    = $this->dekripsi($iddosen);
        $iddosen    = substr($id_user, 3);

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $kelompok  = DB::table('jadwal')
                    ->join('users', 'jadwal.id_user','=','users.id_user')
                    ->select('jadwal.kelompok')
                    ->where('jadwal.id_mtk','=',$idmtk)
                    ->Where('jadwal.id_user','=',$iddosen)
                    ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                    ->where('jadwal.semester','=',$semester->semester)
                    ->get();

                    if(count($kelompok) == 0){
                        $data = array();
                        $data[] = array("kelompok"=> "Kelompok Tidak Tersedia");
                    return response()->json([
                        'error' => false,
                        "data" => $data
                        ]);  
                }
                else{
                    return response()->json([
                        'error' => false,
                        'data' => $kelompok
                        ]);
                }
                    
    }

    public function cek_jam(Request $request){


        $id_mtk     = $request->get('idmtk');
        $lab        = $request->get('lab');
        $hari       = $request->get('hari');
        $jamAjar    = $request->get('jamAjar');

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $jumlahSks    = Matakuliah::select('sks_mtk')->where('id_mtk','=',$id_mtk)->first();
        
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

        
        $cekwaktu        = Jadwal::select('jam_ajar')   ->where('id_lab', $lab)
                                                        ->where('hari', $hari)
                                                        ->where('semester', $semester->semester)
                                                        ->where('tahunajaran', $tahun->tahunajaran)
                                                        ->get();

                       
                                                    
        
        $cek = 0;

        for($i=0; $i<count($jamAjar); $i++){
            $jamAjarMasuk[$i]    = substr($jamAjar[$i], 0, -8);  
            $jamAjarKeluar[$i]   = substr($jamAjar[$i], -5);
        }

        $jam_api = array();       
        foreach($cekwaktu as $cekwaktus) 
        {
            for($i=0; $i<count($cekwaktu); $i++){
                $jamMasuk[$i]    = substr($cekwaktu[$i]->jam_ajar, 0, -8);  
                $jamKeluar[$i]   = substr($cekwaktu[$i]->jam_ajar, -5);
            }
            // $k=0;
            // $flag=0;
            $jam_api = $jamAjar;

            for($i=0;$i<count($cekwaktu);$i++){  
                for($j=0;$j<count($jamAjar);$j++){

                    // if($jamAjar ) {

                    // }

                    if($jamKeluar[$i] >= $jamAjarMasuk[$j] && $jamMasuk[$i] <= $jamAjarKeluar[$j]) {
                        // break;
                    }
                    else {
                        break;
                    }
                    
                    echo $jamMasuk[$i] .' - '. $jamKeluar[$i] .' ||| '. $jamAjarMasuk[$j] .' - '. $jamAjarKeluar[$j] . '<br>';
                    //     {
                    //         echo $jamMasuk[$j] .' - '. $jamKeluar[$j] .' ||| '. $jamAjarMasuk[$i] .' - '. $jamAjarKeluar[$i] . '<br>';
                    //         $flag=1;
                    //         break;
                    //     }
                    // else{
                    //     $jam_api[$k] = $jamAjar[$i];
                    //     $flag=0;
                    // }
                }
                // $k++;
            }
            dd($jam_api);
        }
    }



    function tambahkp(Request $request)
    {
        $jadwal = auth()->user()->jadwal;

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $validator = Validator::make($request->all(), [
            'id_matkul' => 'required',
            'id_dosen' => 'required',
            'kelompok'=> 'required',
            'lab' => 'required',
            'tanggal' => 'required',
            'jam_ajar'=> 'required'
           
        ]);
        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'message' => $validator->errors()
            ]
            );
        }
        $mtk        = $request->id_matkul;
        if($mtk == 0){
            return response()->json([
                'success' => false,
                'message' => 'Kuliah Pengganti tidak Dapat disimpan'
            ]); 
        }

        $mtk        = $request->id_matkul;
        $dosen      = $request->id_dosen;
        $id_user    = $this->dekripsi($dosen);
        $dosen      = substr($id_user, 3);
        $kelompok   = strtoupper($request->kelompok);
        $lab        = $request->lab;
        $tanggalkp  = $request->tanggal;
        $jamAjar    = $request->jam_ajar;

        $tanggal    = $this->caritanggal($tanggalkp);
        $hari       = $this->carihari($tanggal);
    
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);
        
        $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $lab)
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
                            ->where('kuliahpengganti.id_lab', '=', $lab)
                            ->where('kuliahpengganti.tanggal_pengganti', '=', $tanggal)
                            ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                            ->where('jadwal.semester','=',$semester->semester)
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
                                ->where('id_lab', '=', $lab)
                                ->where('tanggal_pinjam', '=', $tanggal)
                                ->where('pinjamlab.status' , '=', 1)
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

        //ini proses untuk menyimpan data ke db
        if($cek == 0)
        {
            $jadwal = Jadwal::select('id_jadwal')
                            ->where('kelompok','=', $kelompok)
                            ->where('id_user', $dosen)
                            ->where('id_mtk', $mtk)
                            ->where('semester', $semester->semester)
                            ->where('tahunajaran', $tahun->tahunajaran)
                            ->first();

            //menambah kan str untuk meminalkan eror
            $jamAjar = "enc" .$jamAjar;
            $tanggal = "enc" .$tanggal;
            $lab     = "enc" .$lab;
            $id_jadwal = "enc" .$jadwal->id_jadwal;
            //proses enkripsi
            $jamAjar = $this->enkripsi($jamAjar);
            $tanggal = $this->enkripsi($tanggal);
            $lab     = $this->enkripsi($lab);
            $id_jadwal = $this->enkripsi($id_jadwal);

            $data[] = array(
                "id_jadwal"=>  $id_jadwal,
                "lab"=> $lab,
                "tanggal" => $tanggal,
                "jamAjar" => $jamAjar
            );
            

            return response()->json([
                'success' => true,
                'message' => 'Data Kuliah Pengganti Telah dienkripsi',
                "id_jadwal"=>  $id_jadwal,
                "lab"=> $lab,
                "tanggal" => $tanggal,
                "jamAjar" => $jamAjar
            ]);          
        }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Kuliah pengganti anda bentrok dengan jadwal yang ada'
                ]);
            
            } 
    }

    function dekripsikp(Request $request)
    {
        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();

        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_jadwal' => 'required',
            'id_lab' => 'required',
            'jamAjar' => 'required',
            'tanggal' => 'required'
           
        ]);
        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'message' => $validator->errors()
            ]
            );
        }

        //ini mendapatkan data
        $id_user     = $request->id_user;
        $id_jadwal     = $request->id_jadwal;
        $id_lab     = $request->id_lab;
        $jamAjar     = $request->jamAjar;
        $tanggal     = $request->tanggal;

        //proses dekripsi
        $id_user    = $this->dekripsi($id_user);
        $id_user    = substr($id_user, 3);
        $id_jadwal  = $this->dekripsi($id_jadwal);
        $id_jadwal  = substr($id_jadwal, 3);
        $id_lab     = $this->dekripsi($id_lab);
        $id_lab     = substr($id_lab, 3);
        $jamAjar     = $this->dekripsi($jamAjar);
        $jamAjar     = substr($jamAjar, 3);
        $tanggal     = $this->dekripsi($tanggal);
        $tanggal     = substr($tanggal, 3);

        

        $user = User::select('nama')->where('id_user', $id_user)->get();

       
        if(count($user)==1){
        $kp    = new KuliahPengganti();
        
        $kp     -> jam_Pengganti        = $jamAjar;
        $kp     -> tanggal_Pengganti    = $tanggal;
        $kp     -> id_lab               = $id_lab;
        $kp     -> id_jadwal            = $id_jadwal;


        
            if($kp->save()){
            return response()->json([
                'success' => true,
                'message' => 'data berhasil disimpan'
            ]); 
            }
            else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Peminjaman lab anda bentrok dengan jadwal yang ada'
                    ]);
            }
        }     
    }

    function tambahkpweb(Request $request)
    {
        $jadwal = auth()->user()->jadwal;

        $tahun      = TahunAjaran::select('tahunajaran')->where('status_tahunajaran','=','1')->first();
        $semester   = Semester::select('semester')->where('status_semester','=','1')->first();
        $cariLab    = Lab::select('id_lab')->where('nama_lab', $request->get('lab'))->first();
        

        $validator = Validator::make($request->all(), [
            'id_matkul' => 'required',
            'id_dosen' => 'required',
            'kelompok'=> 'required',
            'lab' => 'required',
            'tanggal' => 'required',
            'jam_ajar'=> 'required'
           
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $mtk        = $request->id_matkul;
        $dosen      = $request->id_dosen;
        $kelompok   = strtoupper($request->kelompok);
        $lab        = $cariLab->id_lab;
        $tanggalkp  = $request->tanggal;
        $jamAjar    = $request->jam_ajar;

        $tanggal    = $this->caritanggal($tanggalkp);
        $hari       = $this->carihari($tanggal);
    
        $cek = 0;
        $jamAjarMasuk    = substr($jamAjar, 0, -8);  
        $jamAjarKeluar   = substr($jamAjar, -5);
        
        $cekwaktu       = Jadwal::select('jam_ajar')    ->where('id_lab', $lab)
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
                            ->where('kuliahpengganti.id_lab', '=', $lab)
                            ->where('kuliahpengganti.tanggal_pengganti', '=', $tanggal)
                            ->where('jadwal.tahunajaran','=',$tahun->tahunajaran)
                            ->where('jadwal.semester','=',$semester->semester)
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
                            ->where('id_user', $dosen)
                            ->where('id_mtk', $mtk)
                            ->where('semester', $semester->semester)
                            ->where('tahunajaran', $tahun->tahunajaran)
                            ->first();

                            

            $kp    = new KuliahPengganti();
            
            $kp     -> jam_Pengganti        = $jamAjar;
            $kp     -> tanggal_Pengganti    = $tanggal;
            $kp     -> id_lab               = $lab;
            $kp     -> id_jadwal            = $jadwal -> id_jadwal;
            
           if($kp->save()){
            return response()->json([
                'success' => true,
                'message' => 'data berhasil disimpan'
            ]); 
            }
            else{
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

    function prosestambah(Request $request)
    {
        $jadwal = auth()->user()->jadwal;
        

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'judul' => 'required',
            'keterangan'=> 'required',
            'tanggal' => 'required',
            'jamMulai' => 'required',
            'jamSelesai'=> 'required',
            'lab' => 'required',
            'email' => 'required'
           
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

    function dekripsi($plaintext){
        $inputText = $plaintext;
        $inputKey = "abcdefghijuklmno0123456789012345";
        $blockSize = 256;
        $aes = new Prosesaes($inputText, $inputKey, $blockSize);
        $aes->setData($inputText);
        $dec=$aes->decrypt();

        return $dec;
    }

    function enkripsi($plaintext){
        $inputText = $plaintext;
         $inputKey = "abcdefghijuklmno0123456789012345";
         $blockSize = 256;
         $aes = new Prosesaes($inputText, $inputKey, $blockSize);
         $enc = $aes->encrypt();

         return $enc;
    }
}
