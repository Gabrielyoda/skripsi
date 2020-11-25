<?php

namespace App\Http\Controllers;
use App\Lab;
use App\Admin;

use Illuminate\Http\Request;

class LabController extends Controller
{
    function index(Request $request)
    {
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $lab  = Lab::all();

        return view('labadmin')
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Lab');
    }

    function tambah(Request $request)
    { 
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        return view('tambahlab')
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Lab');
    }

    function prosestambah(Request $request)
    {
        $nama       = $request->get('namaLab');
        $kapasitas  = $request->get('kapasitasLab');

        $lab    = new lab();
        
        $lab    -> nama_lab         = $nama;
        $lab    -> kapasitas_lab    = $kapasitas;

        if($lab->save())
        {
            return redirect('/admin/lab');
        }
    }

    function ubah(Request $request, $id)
    { 
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $lab  = Lab::find($id);

        return view('ubahlab')
        ->with('lab', $lab)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Data Lab');
    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        $nama       = $request->get('namaLab');
        $kapasitas  = $request->get('kapasitasLab');

        $lab    = Lab::find($id);
        
        $lab    -> nama_lab         = $nama;
        $lab    -> kapasitas_lab    = $kapasitas;

        if($lab->save())
        {
            return redirect('/admin/lab');
        }
    }

    function hapus(Request $request, $id)
    {
        $lab    = Lab::find($id);

        if($lab -> delete())
        {
            return redirect('/admin/lab');
        }
    }
}
