<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\TahunAjaran;
use App\Semester;

class AdminController extends Controller
{
    function index(Request $request)
    {
        $admin          = Admin::find($request->session()->get('nim'));
        $tahunajaran    = TahunAjaran::orderBy('tahunajaran', 'ASC')->get();
        $semester       = Semester::orderBy('semester', 'ASC')->get();
        
        if($request->session()->get('semester') && $request->session()->get('tahunajaran') != null)
        {
            $nama   = $admin -> nama_admin;
            
            return view('opsiadmin')
            ->with('tahunajaran',$tahunajaran)
            ->with('semester',$semester)
            ->with('nama',$nama)
            ->with('datasemester', $request->session()->get('semester'))
            ->with('datatahunajar', $request->session()->get('tahunajaran'));
        }
        else
        {
            $nama   = $admin -> nama_admin;

            return view('opsiadmin')
            ->with('tahunajaran',$tahunajaran)
            ->with('semester',$semester)
            ->with('nama',$nama)
            ->with('datasemester', null)
            ->with('datatahunajar', null);
        }
    }

    function tampil(Request $request)
    {
        $request->session() -> put('semester', $request->get('smt'));
        $request->session() -> put('tahunajaran', $request->get('thnajar'));

        return redirect ('/admin/home');
    }
    
    function home(Request $request)
    {
        $admin  = Admin::find($request->session()->get('nim'));

        $nama   = $admin -> nama_admin;
        $foto   = $admin -> foto_admin;

        $join   = DB::table('jadwal')
                    ->join('matakuliah', 'jadwal.id_mtk','=','matakuliah.id_mtk')
                    ->join('dosen', 'jadwal.id_dosen','=','dosen.id_dosen')
                    ->join('lab', 'jadwal.id_lab','=','lab.id_lab')
                    ->select('jadwal.kelompok','jadwal.hari','jadwal.jam_ajar','matakuliah.kd_mtk','matakuliah.nama_mtk','matakuliah.sks_mtk','dosen.nip_dosen','dosen.nama_dosen','lab.nama_lab','lab.kapasitas_lab')
                    ->where('jadwal.tahunajaran','=',$request->session()->get('tahunajaran'))
                    ->where('jadwal.semester','=',$request->session()->get('semester'))
                    ->get();

        return view('homeadmin')
        ->with('join',$join)
        ->with('nama',$nama)
        ->with('foto',$foto)
        ->with('semester',$request->session()->get('semester'))
        ->with('tahunajaran',$request->session()->get('tahunajaran'))
        ->with('title', 'Dashboard');
    }

    function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/admin/login');
    }
}
