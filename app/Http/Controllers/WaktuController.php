<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\TahunAjaran;
use App\Semester;
use App\User;

class WaktuController extends Controller
{
    function index(Request $request)
    {
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        $thajar     = TahunAjaran::orderBy('tahunajaran', 'ASC')->get();
        $smt        = Semester::orderBy('semester', 'ASC')->get();

        return view('waktuadmin')
        ->with('thajar', $thajar)
        ->with('smt', $smt)
        ->with('nama', $nama)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Waktu');
    }

    function tambahtahun(Request $request)
    {
        $tahun  = $request->get('thnajar');

        $tahunajaran    = new tahunajaran();
        
        $tahunajaran    -> tahunajaran          = $tahun;
        $tahunajaran    -> status_tahunajaran   = 0;

        if($tahunajaran->save())
        {
            alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Waktu', 'success')->autoClose(10000);
            return redirect('/admin/waktu');
        }
    }

    function tambahsemester(Request $request)
    {
        $smt    = $request->get('semester');

        $semester    = new semester();
        
        $semester    -> semester          = $smt;
        $semester    -> status_semester   = 0;

        if($semester->save())
        {
            alert()->html('Berhasil Tambah Data', 'Berhasil Menambahkan Data Waktu', 'success')->autoClose(10000);
            return redirect('/admin/waktu');
        }
    }

    function aktifkantahun(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        TahunAjaran::where('status_tahunajaran', 1)
                    ->update(['status_tahunajaran' => '0']);

        $tahunajaran    = TahunAjaran::find($id);
        $tahunajaran    -> status_tahunajaran      = 1;
            
        if($tahunajaran->save())
        {
            return redirect('/admin/waktu');
        }
    }

    function aktifkansemester(Request $request, $id)
    { 
        $user = User::find($request->session()->get('nim'));

        $nama = $user -> nama;

        Semester::where('status_semester', 1)
                ->update(['status_semester' => '0']);

        $semester    = Semester::find($id);
        $semester    -> status_semester      = 1;
            
        if($semester->save())
        {
            return redirect('/admin/waktu');
        }
    }

    function hapustahun(Request $request, $id)
    {
        $tahunajaran    = TahunAjaran::find($id);

        if($tahunajaran -> delete())
        {
            alert()->html('Berhasil Menghapus Data', 'Berhasil Menghapus Data Waktu', 'success')->autoClose(10000); 
            return redirect('/admin/waktu');
        }
    }

    function hapussemester(Request $request, $id)
    {
        $semester    = Semester::find($id);

        if($semester -> delete())
        {
            alert()->html('Berhasil Menghapus Data', 'Berhasil Menghapus Data Waktu', 'success')->autoClose(10000); 
            return redirect('/admin/waktu');
        }
    }
}
