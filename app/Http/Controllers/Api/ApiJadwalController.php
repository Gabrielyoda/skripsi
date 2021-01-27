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

        $jadwalAll=array_merge($jadwal,$joinKP);
                    
        
        
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

        return response()->json([
            'error' => false,
            'data' => $dosen
            ]);
    }

    function carikelompok(Request $request)
    {   
        $idmtk      = $request->get('idmtk');
        $iddosen    = $request->get('iddosen');

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


                    return response()->json([
                        'error' => false,
                        'data' => $kelompok
                        ]);
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
            return response()->json($validator->errors());
        }

        $mtk        = $request->id_matkul;
        $dosen      = $request->id_dosen;
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
}
