<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Software;
use App\Admin;

class SoftwareController extends Controller
{
    function index(Request $request)
    {
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $software  = Software::all();

        return view('softwareadmin')
        ->with('software', $software)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Software');
    }

    function tambah(Request $request)
    { 
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        return view('tambahsoftware')
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Software');
    }

    function prosestambah(Request $request)
    {
        $nama       = $request->get('namaSW');

        $software    = new Software();
        
        $software    -> nama_software   = $nama;

        if($software->save())
        {
            return redirect('/admin/software');
        }
    }

    function ubah(Request $request, $id)
    { 
        $admin = Admin::find($request->session()->get('nim'));

        $nama = $admin -> nama_admin;
        $foto = $admin -> foto_admin;

        $software  = Software::find($id);

        return view('ubahsoftware')
        ->with('software', $software)
        ->with('nama', $nama)
        ->with('foto', $foto)
        ->with('semester', $request->session()->get('semester'))
        ->with('tahunajaran', $request->session()->get('tahunajaran'))
        ->with('title', 'Software');
    }

    function prosesubah(Request $request)
    {
        $id         = $request->get('id');
        $nama       = $request->get('namaSW');

        $software    = Software::find($id);
        
        $software    -> nama_software   = $nama;

        if($software->save())
        {
            return redirect('/admin/software');
        }
    }

    function hapus(Request $request, $id)
    {
        $software    = Software::find($id);

        if($software -> delete())
        {
            return redirect('/admin/software');
        }
    }
}
