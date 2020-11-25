<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dosen;
use App\Admin;

class DosenController extends Controller
{
    function index(Request $request)
    {
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $dosen  = Dosen::all();

        return view('dosenadmin')
        ->with('dosen', $dosen)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Dosen');
    }

    function tambah(Request $request)
    { 
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        return view('tambahdosen')
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Dosen');
    }

    function prosestambah(Request $request)
    {
        $nip    = $request->get('nipDosen');
        $nama   = $request->get('namaDosen');

        $dosen    = new dosen();
        
        if(!empty($nip))
        {
            $dosen    -> nip_dosen        = $nip;
        }
        $dosen    -> nama_dosen       = $nama;

        if($dosen->save())
        {
            return redirect('/admin/dosen');
        }
    }

    function ubah(Request $request, $id)
    { 
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $dosen  = Dosen::find($id);

        return view('ubahdosen')
        ->with('dosen', $dosen)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Dosen');
    }

    function prosesubah(Request $request)
    {
        $id     = $request->get('id');
        $nip    = $request->get('nipDosen');
        $nama   = $request->get('namaDosen');

        $dosen    = Dosen::find($id);
        
        if(!empty($nip))
        {
            $dosen    -> nip_dosen        = $nip;
        }
        $dosen    -> nama_dosen       = $nama;

        if($dosen->save())
        {
            return redirect('/admin/dosen');
        }
    }

    function hapus(Request $request, $id)
    {
        $dosen    = Dosen::find($id);

        if($dosen -> delete())
        {
            return redirect('/admin/dosen');
        }
    }
}
